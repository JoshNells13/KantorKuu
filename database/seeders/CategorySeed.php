<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Perkakas Tangan'],
            ['name' => 'Perkakas Listrik'],
            ['name' => 'Alat Ukur'],
            ['name' => 'Alat Bengkel'],
        ]);
    }
}
