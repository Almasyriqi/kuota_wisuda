<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gelombang_prodi extends Model
{
    use HasFactory;

    protected $table = 'gelombang_prodis';

    protected $fillable=[
        'gelombang_id',
        'prodi_id',
        'kuota'
    ];

    public function gelombang() {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }

    public function prodi() {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }
}
