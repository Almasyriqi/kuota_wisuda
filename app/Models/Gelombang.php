<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    public function prodi() {
        return $this->belongsToMany(Prodi::class, 'gelombang_prodis', 'gelombang_id', 'prodi_id');
    }

    public function gelombang_prodi() {
        return $this->hasMany(gelombang_prodi::class, 'gelombang_id');
    }
}
