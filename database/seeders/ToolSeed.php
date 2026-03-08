<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolSeed extends Seeder
{
    public function run(): void
    {
        DB::table('tools')->insert([
            [
                'category_id' => 1,
                'name' => 'Laptop Kantor',
                'stock' => 8,
                'img' => '../img/laptop.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 1,
                'name' => 'Harddisk Eksternal',
                'stock' => 6,
                'img' => '../img/hdd.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Proyektor',
                'stock' => 3,
                'img' => '../img/proyektor.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'Presenter Wireless',
                'stock' => 5,
                'img' => '../img/pointer.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Kamera Dokumentasi',
                'stock' => 2,
                'img' => '../img/kamera.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 3,
                'name' => 'Tripod Kamera',
                'stock' => 4,
                'img' => '../img/tripod.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Speaker Portable',
                'stock' => 5,
                'img' => '../img/speaker.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Kabel HDMI',
                'stock' => 10,
                'img' => '../img/hdmi.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}