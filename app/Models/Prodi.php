<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    public function gelombang_prodi() {
        return $this->hasMany(gelombang_prodi::class, 'prodi_id');
    }

    public function gelombang() {
        return $this->belongsToMany(Gelombang::class, 'gelombang_prodis', 'prodi_id', 'gelombang_id');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
