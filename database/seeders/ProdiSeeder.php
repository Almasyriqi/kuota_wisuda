<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prodis')->insert([
            'jurusan_id' => 1,
            'jenjang'    => "D4",
            'nama'       => "D4 TEKNIK INFORMATIKA",
        ]);

        DB::table('prodis')->insert([
            'jurusan_id' => 2,
            'jenjang'    => "D4",
            'nama'       => "D4 TEKNIK ELEKTRONIKA",
        ]);

        DB::table('prodis')->insert([
            'jurusan_id' => 2,
            'jenjang'    => "D4",
            'nama'       => "D4 SISTEM KELISTRIKAN",
        ]);

        DB::table('prodis')->insert([
            'jurusan_id' => 2,
            'jenjang'    => "D3",
            'nama'       => "D3 TEKNIK ELEKTRONIKA",
        ]);

        DB::table('prodis')->insert([
            'jurusan_id' => 3,
            'jenjang'    => "D4",
            'nama'       => "D4 MANAJEMEN REKAYASA KONSTRUKSI",
        ]);

        DB::table('prodis')->insert([
            'jurusan_id' => 3,
            'jenjang'    => "D3",
            'nama'       => "D3 TEKNIK SIPIL",
        ]);
    }
}
