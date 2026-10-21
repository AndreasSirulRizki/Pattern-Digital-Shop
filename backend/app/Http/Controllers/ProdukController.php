<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function show($slug)
    {
        $produk = Produk::with('kategori')
            ->where('slug', $slug)
            ->where('status', 'aktif')
            ->firstOrFail();

        // Produk terkait: kategori sama, exclude produk ini
        $produk_terkait = Produk::with('kategori')
            ->where('kategori_id', $produk->kategori_id)
            ->where('id', '!=', $produk->id)
            ->where('status', 'aktif')
            ->latest()
            ->take(4)
            ->get();

        return view('detail', compact('produk', 'produk_terkait'));
    }
}
