<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $produk = \App\Models\Produk::with('kategori')->where('status', 'aktif')->latest()->take(8)->get();
    return view('home', compact('produk'));
})->name('home');

Route::get('/katalog', [\App\Http\Controllers\KatalogController::class, 'index'])->name('katalog');

Route::get('/produk/{slug}', [\App\Http\Controllers\ProdukController::class, 'show'])->name('produk.detail');

Route::middleware('auth')->group(function () {
    Route::get('/keranjang',         [\App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang',        [\App\Http\Controllers\KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}',    [\App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [\App\Http\Controllers\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});

Route::middleware('auth')->group(function () {
    // Checkout utama (auto-detect fisik/digital dari keranjang)
    Route::get('/checkout',  [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    // Alias langsung (redirect ke /checkout)
    Route::get('/checkout-fisik',    [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.fisik');
    Route::get('/checkout-digital',  [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.digital');

    // Pembayaran manual
    Route::post('/payment/upload-bukti/{pesananId}', [\App\Http\Controllers\PaymentController::class, 'uploadBukti'])->name('payment.uploadBukti');
    Route::post('/payment/cod/{pesananId}',          [\App\Http\Controllers\PaymentController::class, 'konfirmasiCOD'])->name('payment.cod');
});



Route::get('/sukses', function () {
    return view('sukses');
})->name('sukses')->middleware('auth');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat')->middleware('auth');

Route::get('/riwayat/{id}', function ($id) {
    return view('riwayat-detail', compact('id'));
})->name('riwayat.detail')->middleware('auth');

Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

Route::get('/cara-pesan', function () {
    return view('cara-pesan');
})->name('cara-pesan');

Route::post('/newsletter/subscribe', function (\Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);
    // Simpan atau kirim email (TODO: implementasi sesuai kebutuhan)
    return back()->with('newsletter_success', 'Terima kasih! Email kamu sudah terdaftar.');
})->name('newsletter.subscribe');

Route::get('/dashboard', function () {
    // Redirect ke admin dashboard kalo role admin, ke riwayat kalo customer
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('riwayat');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ══════════════════════════════════════════
// ADMIN ROUTES
// ══════════════════════════════════════════
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Kelola Produk (CRUD)
        Route::get('/produk', [\App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('produk');
        Route::post('/produk', [\App\Http\Controllers\Admin\ProdukController::class, 'store'])->name('produk.store');
        Route::put('/produk/{id}', [\App\Http\Controllers\Admin\ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [\App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('produk.destroy');

        // Kelola Pesanan (CRUD)
        Route::get('/pesanan', [\App\Http\Controllers\Admin\PesananController::class, 'index'])->name('pesanan');
        Route::put('/pesanan/{id}/status', [\App\Http\Controllers\Admin\PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
        Route::delete('/pesanan/{id}', [\App\Http\Controllers\Admin\PesananController::class, 'destroy'])->name('pesanan.destroy');

        // Kelola Customer (CRUD)
        Route::get('/customer', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customer');
        Route::get('/customer/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('customer.show');
        Route::put('/customer/{id}/status', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleStatus'])->name('customer.toggleStatus');
        Route::delete('/customer/{id}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('customer.destroy');

        // Kelola Kategori (CRUD)
        Route::get('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'index'])->name('kategori');
        Route::post('/kategori', [\App\Http\Controllers\Admin\KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [\App\Http\Controllers\Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Laporan & Analitik
        Route::get('/laporan', function () {
            return view('admin.laporan');
        })->name('laporan');

        // Verifikasi Pembayaran
        Route::get('/pembayaran', [\App\Http\Controllers\Admin\PembayaranController::class, 'index'])->name('pembayaran');
        Route::put('/pembayaran/{id}/verifikasi', [\App\Http\Controllers\Admin\PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');

        // Redirect /admin → /admin/dashboard
        Route::redirect('/', '/admin/dashboard');
    });
