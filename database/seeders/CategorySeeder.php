<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'catename' => 'Điện thoại',
                'description' => 'Các dòng điện thoại thông minh',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Laptop',
                'description' => 'Máy tính xách tay các loại',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Tablet',
                'description' => 'Thiết bị máy tính bảng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Phụ kiện',
                'description' => 'Ốp lưng, tai nghe, sạc,...',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Tivi',
                'description' => 'Tivi thông minh, màn hình lớn',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Đồng hồ thông minh',
                'description' => 'Smartwatch các hãng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Máy ảnh',
                'description' => 'Camera chuyên dụng, kỹ thuật số',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Máy in',
                'description' => 'Máy in laser, phun màu,...',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Thiết bị mạng',
                'description' => 'Router, modem, thiết bị WiFi',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'catename' => 'Gaming',
                'description' => 'Bàn phím, chuột, tai nghe chơi game',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
