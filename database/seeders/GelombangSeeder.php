<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GelombangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gelombangs')->insert([
            'nama'          => 1,
            'tanggal_wisuda'=> '2023-09-23',
            'jenis'         => 'OFFLINE',
            'kuota'         => 920,
            'current_kuota' => 733,
        ]);
    }
}
