<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nid',
        'nama',
        'alamat',
        'mata_kuliah',
    ];

    public function getMataKuliahAttribute()
    {
        return $this->attributes['mata_kuliah'] ?? null;
    }
}
