<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaystationController;
use App\Http\Controllers\BookingController;

// Halaman awal
Route::get('/', function () { return view('auth.login'); })->name('home');

// Grup rute yang membutuhkan login
Route::middleware(['auth'])->group(function () {
    Route::put('/admin/playstation/{id}', [PlaystationController::class, 'update'])->name('admin.playstation.update');
    // User: Halaman Rental
    Route::get('/rental', [PlaystationController::class, 'index'])->name('rental.index');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    
    // Admin: Dashboard & Manajemen Unit
    Route::get('/admin/dashboard', [BookingController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/playstation/store', [PlaystationController::class, 'store'])->name('admin.playstation.store');
    Route::delete('/admin/playstation/{id}', [PlaystationController::class, 'destroy'])->name('admin.playstation.destroy');
    
    // Admin: Fitur Selesai (Mengembalikan unit ke status tersedia)
    Route::post('/admin/booking/selesai/{id}', [BookingController::class, 'selesai'])->name('admin.booking.selesai');
});

// Redirect dashboard bawaan ke halaman rental
Route::get('/dashboard', function () { return redirect()->route('rental.index'); })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';