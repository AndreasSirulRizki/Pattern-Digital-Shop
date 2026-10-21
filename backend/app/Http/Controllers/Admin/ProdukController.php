<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Tampilkan daftar produk dengan filter & pagination.
     */
    public function index()
    {
        $produk = Produk::with('kategori')
            ->when(request('search'), function ($q) {
                $q->where('nama_produk', 'like', '%' . request('search') . '%')
                  ->orWhere('slug', 'like', '%' . request('search') . '%');
            })
            ->when(request('kategori_id'), function ($q) {
                $q->where('kategori_id', request('kategori_id'));
            })
            ->when(request('tipe'), function ($q) {
                $q->where('tipe', request('tipe'));
            })
            ->when(request('status'), function ($q) {
                $q->where('status', request('status'));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $kategori    = Kategori::orderBy('nama_kategori')->get();
        $totalProduk = Produk::count();
        $aktifCount  = Produk::where('status', 'aktif')->count();

        return view('admin.produk', compact('produk', 'kategori', 'totalProduk', 'aktifCount'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'    => 'required|string|max:200|unique:produk,nama_produk',
            'kategori_id'    => 'required|exists:kategori,id',
            'tipe'           => 'required|in:fisik,digital',
            'harga'          => 'required|numeric|min:0',
            'stok'           => 'required_if:tipe,fisik|nullable|integer|min:0',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'       => 'required_if:tipe,digital|nullable|file|mimes:pdf|max:51200',
            'status'         => 'required|in:aktif,nonaktif',
            'status_kondisi' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $validated) {
            $slug  = Str::slug($validated['nama_produk']);
            $count = Produk::where('slug', 'like', $slug . '%')->count();
            $validated['slug'] = $count > 0 ? $slug . '-' . ($count + 1) : $slug;

            if ($validated['tipe'] === 'digital') {
                $validated['stok'] = 0;
            }

            $validated['status_kondisi'] = $validated['status_kondisi'] ?? 'Baik';

            if ($request->hasFile('gambar')) {
                $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
            }

            if ($request->hasFile('file_pdf')) {
                $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
            }

            Produk::create($validated);
        });

        return redirect()->route('admin.produk')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil ditambahkan.');
    }

    /**
     * Update produk yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $validated = $request->validate([
            'nama_produk'    => 'required|string|max:200|unique:produk,nama_produk,' . $id,
            'kategori_id'    => 'required|exists:kategori,id',
            'tipe'           => 'required|in:fisik,digital',
            'harga'          => 'required|numeric|min:0',
            'stok'           => 'required_if:tipe,fisik|nullable|integer|min:0',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file_pdf'       => 'nullable|file|mimes:pdf|max:51200',
            'status'         => 'required|in:aktif,nonaktif',
            'status_kondisi' => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request, $validated, $produk) {
            if ($produk->nama_produk !== $validated['nama_produk']) {
                $slug  = Str::slug($validated['nama_produk']);
                $count = Produk::where('slug', 'like', $slug . '%')
                               ->where('id', '!=', $produk->id)
                               ->count();
                $validated['slug'] = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
            }

            if ($validated['tipe'] === 'digital') {
                $validated['stok'] = 0;
            }

            $validated['status_kondisi'] = $validated['status_kondisi'] ?? $produk->status_kondisi ?? 'Baik';

            if ($request->hasFile('gambar')) {
                if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $validated['gambar'] = $request->file('gambar')->store('produk', 'public');
            }

            if ($request->hasFile('file_pdf')) {
                if ($produk->file_pdf && Storage::disk('public')->exists($produk->file_pdf)) {
                    Storage::disk('public')->delete($produk->file_pdf);
                }
                $validated['file_pdf'] = $request->file('file_pdf')->store('pdf', 'public');
            }

            $produk->update($validated);
        });

        return redirect()->route('admin.produk')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil diupdate.');
    }

    /**
     * Hapus produk dari database beserta file-nya.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $nama   = $produk->nama_produk;

        DB::transaction(function () use ($produk) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            if ($produk->file_pdf && Storage::disk('public')->exists($produk->file_pdf)) {
                Storage::disk('public')->delete($produk->file_pdf);
            }

            $produk->delete();
        });

        return redirect()->route('admin.produk')
            ->with('success', 'Produk "' . $nama . '" berhasil dihapus.');
    }
}
