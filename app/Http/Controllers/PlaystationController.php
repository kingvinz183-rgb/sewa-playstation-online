<?php

namespace App\Http\Controllers;

use App\Models\Playstation;
use Illuminate\Http\Request;

class PlaystationController extends Controller
{
    // Menampilkan semua data PS di halaman depan
    public function index()
    {
        $playstations = Playstation::all();
        return view('welcome', compact('playstations'));
    }

    // Menangani tambah unit PS baru
    public function store(Request $request)
{
    $request->validate([
        'nama_unit' => 'required',
        'jenis' => 'required',
        'harga_per_jam' => 'required|numeric',
    ]);

    Playstation::create([
        'nama_unit' => $request->nama_unit,
        'jenis' => $request->jenis, // Pastikan ada kolom 'jenis' di tabel database
        'harga_per_jam' => $request->harga_per_jam,
        'status' => 'tersedia',
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'Unit berhasil ditambahkan!');
}

    // Menangani update data unit PS (Edit)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'harga_per_jam' => 'required|numeric|min:0',
        ]);

        $ps = Playstation::findOrFail($id);
        
        // Update hanya field yang relevan
        $ps->update([
            'nama_unit' => $request->nama_unit,
            'harga_per_jam' => $request->harga_per_jam,
        ]);

        // Menggunakan session key 'success' agar seragam dengan notifikasi lainnya
        return back()->with('success', 'Data unit berhasil diperbarui!');
    }
}