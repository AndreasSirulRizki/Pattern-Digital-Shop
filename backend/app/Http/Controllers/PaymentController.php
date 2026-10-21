<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Upload bukti pembayaran (QRIS / Transfer Bank).
     */
    public function uploadBukti(Request $request, $pesananId)
    {
        $request->validate([
            'bukti'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode' => 'required|in:qris,transfer',
        ], [
            'bukti.required' => 'Bukti pembayaran wajib diupload.',
            'bukti.image'    => 'File harus berupa gambar.',
            'bukti.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id', $pesananId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Upload gambar ke storage/app/public/bukti-transfer
            $path = $request->file('bukti')->store('bukti-transfer', 'public');

            // Upsert: kalau sudah ada pembayaran untuk pesanan ini, update saja
            Pembayaran::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'metode'  => $request->metode,
                    'status'  => 'pending',
                    'bukti'   => $path,
                ]
            );

            // Status pesanan jadi pending (menunggu verifikasi admin)
            $pesanan->update(['status' => 'pending']);

            DB::commit();

            return redirect()->route('sukses', ['order' => $pesanan->no_order])
                ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal upload bukti: ' . $e->getMessage());
        }
    }

    /**
     * Konfirmasi pesanan COD — langsung set status diproses.
     */
    public function konfirmasiCOD($pesananId)
    {
        DB::beginTransaction();
        try {
            $pesanan = Pesanan::where('id', $pesananId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            Pembayaran::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'metode' => 'cod',
                    'status' => 'pending',
                ]
            );

            $pesanan->update(['status' => 'diproses']);

            DB::commit();

            return redirect()->route('sukses', ['order' => $pesanan->no_order])
                ->with('success', 'Pesanan COD berhasil dibuat. Bayar saat barang diterima.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
