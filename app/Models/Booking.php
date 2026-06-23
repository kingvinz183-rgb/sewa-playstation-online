<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'playstation_id',
    'durasi',
    'total_harga',
];

    // Hubungan ke model User (Penyewa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke model Playstation (PASTIKAN NAMANYA HURUF KECIL: playstation)
    public function playstation()
    {
        return $this->belongsTo(Playstation::class, 'playstation_id');
    }
}