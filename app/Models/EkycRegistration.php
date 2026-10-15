<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkycRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nik',
        'tanggal_lahir',
        'alamat',
        'file_ktp',
        'file_kk',
        'file_ijazah',
        'file_selfie',
        'asal_sd',
        'asal_smp',
        'asal_sma',
        'alamat_domisili',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'nama_ibu_kandung',
        'referensi_sumber',
        'status',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
