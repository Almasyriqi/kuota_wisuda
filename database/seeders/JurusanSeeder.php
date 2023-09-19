<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusans')->insert([
            'nama' => "TEKNOLOGI INFORMASI",
        ]);

        DB::table('jurusans')->insert([
            'nama' => "TEKNIK ELEKTRO",
        ]);

        DB::table('jurusans')->insert([
            'nama' => "TEKNIK SIPIL",
        ]);
    }
}
