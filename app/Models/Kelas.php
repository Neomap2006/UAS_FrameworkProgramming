<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
    ];

    // Relasi: 1 kelas punya banyak mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id');
    }
}
