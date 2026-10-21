<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Daftar semua pembayaran — untuk verifikasi admin.
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by metode
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $pembayaran = $query->paginate(15)->withQueryString();

        // Stats ringkasan
        $stats = [
            'pending'  => Pembayaran::where('status', 'pending')->count(),
            'berhasil' => Pembayaran::where('status', 'berhasil')->count(),
            'gagal'    => Pembayaran::where('status', 'gagal')->count(),
            'total'    => Pembayaran::count(),
        ];

        return view('admin.pembayaran.index', compact('pembayaran', 'stats'));
    }

    /**
     * Verifikasi / batalkan pembayaran.
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:berhasil,gagal',
        ]);

        $pembayaran = Pembayaran::with('pesanan')->findOrFail($id);
        $pembayaran->update(['status' => $request->status]);

        // Update status pesanan berdasarkan hasil verifikasi
        if ($request->status === 'berhasil') {
            $pembayaran->pesanan->update(['status' => 'diproses']);
        } else {
            $pembayaran->pesanan->update(['status' => 'dibatalkan']);
        }

        $label = $request->status === 'berhasil' ? 'diverifikasi ✓' : 'ditolak ✗';

        return back()->with('success', "Pembayaran #{$pembayaran->pesanan->no_order} berhasil {$label}.");
    }
}
