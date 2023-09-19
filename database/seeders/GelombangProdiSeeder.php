<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GelombangProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gelombang_prodis')->insert([
            'gelombang_id'     => 1,
            'prodi_id'         => 1,
            'kuota'            => 91,
        ]);

        DB::table('gelombang_prodis')->insert([
            'gelombang_id'     => 1,
            'prodi_id'         => 2,
            'kuota'            => 53,
        ]);

        DB::table('gelombang_prodis')->insert([
            'gelombang_id'     => 1,
            'prodi_id'         => 3,
            'kuota'            => 43,
        ]);
    }
}
