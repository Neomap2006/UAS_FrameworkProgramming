<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tentang extends Model
{
    protected $table = 'tentang';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar'
    ];
}
