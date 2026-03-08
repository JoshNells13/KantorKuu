<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Perangkat Komputer'],
            ['name' => 'Perangkat Presentasi'],
            ['name' => 'Peralatan Dokumentasi'],
            ['name' => 'Perlengkapan Meeting'],
            ['name' => 'Peralatan Jaringan'],
        ]);
    }
}