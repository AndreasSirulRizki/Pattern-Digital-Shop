<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar customer dengan filter & pagination.
     */
    public function index()
    {
        $customer = User::where('role', 'customer')
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%')
                  ->orWhere('no_hp', 'like', '%' . request('search') . '%');
            })
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->withCount('pesanan')
            ->withSum('pesanan', 'total')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Stats
        $stats = [
            'total'       => User::where('role', 'customer')->count(),
            'aktif'       => User::where('role', 'customer')->where('status', 'aktif')->count(),
            'nonaktif'    => User::where('role', 'customer')->where('status', 'nonaktif')->count(),
            'baru_bulan'  => User::where('role', 'customer')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count(),
        ];

        return view('admin.customer', compact('customer', 'stats'));
    }

    /**
     * Ambil detail customer via JSON (untuk modal).
     */
    public function show($id)
    {
        $customer = User::where('role', 'customer')
            ->with(['pesanan' => function ($q) {
                $q->latest()->take(5);
            }])
            ->withCount('pesanan')
            ->withSum('pesanan', 'total')
            ->findOrFail($id);

        return response()->json([
            'id'            => $customer->id,
            'nama'          => $customer->name,
            'email'         => $customer->email,
            'no_hp'         => $customer->no_hp ?? '—',
            'alamat'        => $customer->alamat ?? '—',
            'status'        => $customer->status,
            'daftar'        => $customer->created_at->format('d M Y'),
            'pesanan_count' => $customer->pesanan_count,
            'pesanan_sum'   => $customer->pesanan_sum_total ?? 0,
            'pesanan_terakhir' => $customer->pesanan->first()?->created_at?->format('d M Y') ?? '—',
            'riwayat'       => $customer->pesanan->map(fn($p) => [
                'no'     => $p->no_order,
                'tgl'    => $p->created_at->format('d M Y'),
                'total'  => 'Rp ' . number_format($p->total, 0, ',', '.'),
                'status' => $p->status,
            ]),
        ]);
    }

    /**
     * Toggle status aktif/nonaktif customer.
     */
    public function toggleStatus($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $customer->status = $customer->status === 'aktif' ? 'nonaktif' : 'aktif';
        $customer->save();

        $label = $customer->status === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', 'Customer "' . $customer->name . '" berhasil ' . $label . '.');
    }

    /**
     * Hapus customer dari database.
     */
    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        $nama     = $customer->name;

        // Hapus relasi dulu (keranjang)
        $customer->keranjang()->delete();

        // Pesanan tidak dihapus (historical data), hanya user
        $customer->delete();

        return redirect()->route('admin.customer')
            ->with('success', 'Customer "' . $nama . '" berhasil dihapus.');
    }
}
