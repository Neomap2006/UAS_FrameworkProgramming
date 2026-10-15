<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    // pointing table
    protected $table = 'mahasiswa';

    // kolom yang bisa di set by user
    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'kelas_id',
    ];

    // Relasi: Mahasiswa milik 1 Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
