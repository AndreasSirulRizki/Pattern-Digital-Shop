<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::with('produk.kategori')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $subtotal = $keranjang->sum(function ($item) {
            return ($item->produk->harga ?? 0) * $item->jumlah;
        });

        // Ongkir: gratis kalau semua digital, 15.000 kalau ada fisik
        $adaFisik = $keranjang->contains(fn($i) => optional($i->produk)->tipe === 'fisik');
        $ongkir   = ($subtotal > 0 && $adaFisik) ? 15000 : 0;
        $total    = $subtotal + $ongkir;

        return view('keranjang', compact('keranjang', 'subtotal', 'ongkir', 'total', 'adaFisik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Cek stok (hanya untuk produk fisik)
        if ($produk->tipe === 'fisik' && $request->jumlah > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi. Sisa stok: ' . $produk->stok . ' pcs.');
        }

        // Kalau produk sudah ada di keranjang, tambah jumlahnya
        $existing = Keranjang::where('user_id', Auth::id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($existing) {
            $newJumlah = $existing->jumlah + $request->jumlah;
            // Re-cek stok setelah ditambah
            if ($produk->tipe === 'fisik' && $newJumlah > $produk->stok) {
                return back()->with('error', 'Total jumlah melebihi stok. Sisa stok: ' . $produk->stok . ' pcs.');
            }
            $existing->update(['jumlah' => $newJumlah]);
        } else {
            Keranjang::create([
                'user_id'   => Auth::id(),
                'produk_id' => $request->produk_id,
                'jumlah'    => $request->jumlah,
            ]);
        }

        return redirect()->route('keranjang')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $item   = Keranjang::where('user_id', Auth::id())->findOrFail($id);
        $produk = $item->produk;

        // Cek stok kalau fisik
        if ($produk->tipe === 'fisik' && $request->jumlah > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi. Sisa stok: ' . $produk->stok . ' pcs.');
        }

        $item->update(['jumlah' => $request->jumlah]);

        return redirect()->route('keranjang')->with('success', 'Jumlah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Keranjang::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return redirect()->route('keranjang')->with('success', 'Produk dihapus dari keranjang.');
    }
}
