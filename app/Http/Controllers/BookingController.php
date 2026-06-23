<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Playstation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Menampilkan halaman dashboard admin rekap transaksi
    public function index()
    {
        $bookings = Booking::with('playstation')->latest()->get();
        return view('admin_dashboard', compact('bookings'));
    }

    // Menampilkan form booking unit PS
    public function create($id)
    {
        $playstation = Playstation::findOrFail($id);
        return view('booking_form', compact('playstation'));
    }

    // Menyimpan transaksi booking ke database secara otomatis
    public function store(Request $request)
{
    // Cek sesi sebelum memproses
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Silakan login kembali.');
    }

    $request->validate([
        'playstation_id' => 'required|exists:playstations,id',
        'durasi' => 'required|integer|min:1',
    ]);

    $playstation = \App\Models\Playstation::find($request->playstation_id);
    $total_harga = $playstation->harga_per_jam * $request->durasi;

    \App\Models\Booking::create([
        'user_id'        => auth()->id(), // Mengambil ID user yang sedang aktif
        'playstation_id' => $request->playstation_id,
        'durasi'         => $request->durasi,
        'total_harga'    => $total_harga,
    ]);

    $playstation->update(['status' => 'disewa']);

    return redirect()->route('rental.index')->with('success', 'Booking berhasil!');
}
public function selesai($id)
{
    $booking = \App\Models\Booking::findOrFail($id);
    
    // 1. Ubah status PS kembali jadi tersedia
    $ps = \App\Models\Playstation::find($booking->playstation_id);
    if ($ps) {
        $ps->update(['status' => 'tersedia']);
    }

    // 2. Tandai booking selesai (atau hapus record)
    $booking->delete(); 

    return back()->with('success', 'Sesi sewa selesai, unit kini kembali tersedia!');
}
}