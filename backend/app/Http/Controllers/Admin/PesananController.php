<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Tampilkan daftar pesanan dengan filter & pagination.
     */
    public function index()
    {
        $pesanan = Pesanan::with(['user', 'detailPesanans.produk'])
            ->when(request('search'), function ($q) {
                $q->where('no_order', 'like', '%' . request('search') . '%')
                  ->orWhereHas('user', function ($u) {
                      $u->where('name', 'like', '%' . request('search') . '%')
                        ->orWhere('email', 'like', '%' . request('search') . '%');
                  });
            })
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->when(request('tipe'), function ($q) {
                $q->where('tipe_pesanan', request('tipe'));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // Stat counts
        $stats = [
            'pending'    => Pesanan::where('status', 'pending')->count(),
            'diproses'   => Pesanan::where('status', 'diproses')->count(),
            'dikirim'    => Pesanan::where('status', 'dikirim')->count(),
            'selesai'    => Pesanan::where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'dibatalkan')->count(),
            'total'      => Pesanan::count(),
        ];

        return view('admin.pesanan', compact('pesanan', 'stats'));
    }

    /**
     * Update status pesanan + no_resi.
     */
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'status'  => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
            'no_resi' => [
                'nullable',
                'string',
                'max:50',
                // Wajib isi no_resi jika tipe fisik dan status dikirim
                function ($attribute, $value, $fail) use ($request, $pesanan) {
                    if (
                        $pesanan->tipe_pesanan === 'fisik'
                        && $request->status === 'dikirim'
                        && empty($value)
                    ) {
                        $fail('No. Resi wajib diisi untuk pesanan fisik yang dikirim.');
                    }
                },
            ],
        ]);

        DB::transaction(function () use ($pesanan, $validated) {
            $updateData = ['status' => $validated['status']];

            // Update no_resi hanya jika diisi
            if (!empty($validated['no_resi'])) {
                $updateData['no_resi'] = $validated['no_resi'];
            }

            // Kembalikan stok jika dibatalkan
            if ($validated['status'] === 'dibatalkan' && $pesanan->status !== 'dibatalkan') {
                foreach ($pesanan->detailPesanans as $detail) {
                    if ($detail->produk && $detail->produk->tipe === 'fisik') {
                        $detail->produk->increment('stok', $detail->jumlah);
                    }
                }
            }

            $pesanan->update($updateData);
        });

        return redirect()->back()
            ->with('success', 'Status pesanan #' . $pesanan->no_order . ' berhasil diupdate ke "' . $validated['status'] . '".');
    }

    /**
     * Hapus pesanan beserta detail-nya.
     */
    public function destroy($id)
    {
        $pesanan  = Pesanan::findOrFail($id);
        $no_order = $pesanan->no_order;

        DB::transaction(function () use ($pesanan) {
            $pesanan->detailPesanans()->delete();
            if ($pesanan->pembayaran) {
                $pesanan->pembayaran()->delete();
            }
            $pesanan->delete();
        });

        return redirect()->route('admin.pesanan')
            ->with('success', 'Pesanan #' . $no_order . ' berhasil dihapus.');
    }
}
