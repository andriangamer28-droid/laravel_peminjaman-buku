<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    // Baris ini SANGAT PENTING agar data bisa tersimpan
    protected $fillable = ['nama_alat', 'kategori'];
}