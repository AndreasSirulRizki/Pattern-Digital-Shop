<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout sesuai tipe keranjang.
     */
    public function index()
    {
        $keranjang = Keranjang::with('produk.kategori')
            ->where('user_id', Auth::id())
            ->get();

        if ($keranjang->isEmpty()) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong. Tambahkan produk terlebih dahulu.');
        }

        $subtotal = $keranjang->sum(fn($i) => ($i->produk->harga ?? 0) * $i->jumlah);
        $adaFisik = $keranjang->contains(fn($i) => optional($i->produk)->tipe === 'fisik');
        $ongkir   = $adaFisik ? 15000 : 0;
        $total    = $subtotal + $ongkir;

        if ($adaFisik) {
            return view('checkout-fisik', compact('keranjang', 'subtotal', 'ongkir', 'total', 'adaFisik'));
        } else {
            return view('checkout-digital', compact('keranjang', 'subtotal', 'ongkir', 'total', 'adaFisik'));
        }
    }

    /**
     * Proses checkout — simpan pesanan + detail + kurangi stok + hapus keranjang.
     */
    public function store(Request $request)
    {
        $adaFisik = $request->tipe_pesanan === 'fisik';

        $request->validate([
            'tipe_pesanan'      => 'required|in:fisik,digital',
            'nama_penerima'     => $adaFisik ? 'required|string|max:100' : 'nullable',
            'no_hp'             => $adaFisik ? 'required|string|max:20' : 'nullable',
            'alamat'            => $adaFisik ? 'required|string' : 'nullable',
            'kurir'             => $adaFisik ? 'required|string|max:50' : 'nullable',
            'metode_pembayaran' => 'required|in:qris,transfer,cod',
            'bukti'             => in_array($request->metode_pembayaran, ['qris', 'transfer'])
                                   ? 'required|image|mimes:jpeg,png,jpg|max:2048'
                                   : 'nullable',
        ], [
            'bukti.required' => 'Bukti pembayaran wajib diupload untuk metode QRIS/Transfer.',
            'bukti.image'    => 'Bukti pembayaran harus berupa gambar.',
            'bukti.max'      => 'Ukuran gambar maksimal 2MB.',
        ]);

        DB::beginTransaction();
        try {
            $keranjang = Keranjang::with('produk')
                ->where('user_id', Auth::id())
                ->get();

            if ($keranjang->isEmpty()) {
                throw new \Exception('Keranjang kosong.');
            }

            $subtotal = $keranjang->sum(fn($i) => ($i->produk->harga ?? 0) * $i->jumlah);
            $ongkir   = $adaFisik ? 15000 : 0;
            $total    = $subtotal + $ongkir;

            // Generate no_order unik
            do {
                $noOrder = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
            } while (Pesanan::where('no_order', $noOrder)->exists());

            // Buat pesanan
            $pesanan = Pesanan::create([
                'user_id'       => Auth::id(),
                'no_order'      => $noOrder,
                'tgl_order'     => now(),
                'total'         => $total,
                'status'        => 'pending',
                'tipe_pesanan'  => $request->tipe_pesanan,
                'alamat'        => $request->alamat,
                'kurir'         => $request->kurir,
                'ongkir'        => $ongkir,
            ]);

            // Buat detail pesanan + kurangi stok
            foreach ($keranjang as $item) {
                $produk = $item->produk;

                // Lock stok untuk fisik (anti race condition)
                if ($produk->tipe === 'fisik') {
                    $produkLock = Produk::lockForUpdate()->find($item->produk_id);
                    if ($produkLock->stok < $item->jumlah) {
                        throw new \Exception("Stok '{$produkLock->nama_produk}' tidak mencukupi. Sisa: {$produkLock->stok} pcs.");
                    }
                    $produkLock->decrement('stok', $item->jumlah);
                }

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id'  => $item->produk_id,
                    'jumlah'     => $item->jumlah,
                    'harga'      => $produk->harga,
                    'subtotal'   => $produk->harga * $item->jumlah,
                ]);
            }

            // Hapus keranjang user
            Keranjang::where('user_id', Auth::id())->delete();

            // ── Handle Pembayaran ──────────────────────────────────
            if ($request->metode_pembayaran === 'cod') {
                // COD: langsung simpan, status pesanan jadi diproses
                \App\Models\Pembayaran::create([
                    'pesanan_id' => $pesanan->id,
                    'metode'     => 'cod',
                    'status'     => 'pending',
                ]);
                $pesanan->update(['status' => 'diproses']);

            } elseif ($request->hasFile('bukti')) {
                // QRIS / Transfer: upload bukti, status pesanan tetap pending
                $path = $request->file('bukti')->store('bukti-transfer', 'public');
                \App\Models\Pembayaran::create([
                    'pesanan_id' => $pesanan->id,
                    'metode'     => $request->metode_pembayaran,
                    'status'     => 'pending',
                    'bukti'      => $path,
                ]);
                // status pesanan sudah 'pending' dari awal
            }
            // ── End Handle Pembayaran ──────────────────────────────

            DB::commit();

            return redirect()
                ->route('sukses')
                ->with('no_order', $pesanan->no_order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
