<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tools')->insert([
            [
                'category_id' => 1,
                'name' => 'Obeng Plus',
                'stock' => 20,
                'price_per_day' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Kunci Inggris',
                'stock' => 15,
                'price_per_day' => 7000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Bor Listrik',
                'stock' => 5,
                'price_per_day' => 15000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Meteran',
                'stock' => 10,
                'price_per_day' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
