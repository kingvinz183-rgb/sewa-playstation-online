<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playstation extends Model
{
    // Tambahkan baris ini:
    protected $fillable = ['nama_unit', 'jenis', 'harga_per_jam', 'status'];
}