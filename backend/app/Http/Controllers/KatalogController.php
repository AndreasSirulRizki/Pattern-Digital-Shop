<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori')->where('status', 'aktif');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_produk', 'like', '%' . $q . '%')
                    ->orWhereHas('kategori', fn($k) => $k->where('nama_kategori', 'like', '%' . $q . '%'));
            });
        }

        if ($request->filled('kategori')) {
            $query->whereIn('kategori_id', (array) $request->kategori);
        }

        if ($request->filled('tipe') && in_array($request->tipe, ['fisik', 'digital'])) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', (int) $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', (int) $request->harga_max);
        }

        match ($request->input('sort', 'terbaru')) {
            'termurah' => $query->orderBy('harga', 'asc'),
            'termahal' => $query->orderBy('harga', 'desc'),
            'populer'  => $query->orderBy('created_at', 'desc'),
            default    => $query->latest(),
        };

        $produk   = $query->paginate(12)->withQueryString();
        $kategori = Kategori::withCount('produks')->get();

        return view('katalog', compact('produk', 'kategori'));
    }
}
