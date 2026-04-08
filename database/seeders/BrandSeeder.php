<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'brandname' => 'Apple',
                'description' => 'Thương hiệu nổi tiếng với iPhone, iPad, MacBook',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Samsung',
                'description' => 'Hãng công nghệ Hàn Quốc với các sản phẩm điện thoại, TV',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Sony',
                'description' => 'Nổi tiếng với TV, máy ảnh, PlayStation',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Dell',
                'description' => 'Máy tính và laptop chất lượng cao',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'HP',
                'description' => 'Laptop và thiết bị văn phòng phổ biến',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Asus',
                'description' => 'Chuyên sản xuất laptop, gaming gear',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Xiaomi',
                'description' => 'Thiết bị điện tử giá tốt, chất lượng cao',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Oppo',
                'description' => 'Chuyên điện thoại camera đẹp, selfie',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Canon',
                'description' => 'Hãng máy ảnh, máy in nổi tiếng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brandname' => 'Lenovo',
                'description' => 'Laptop và máy tính văn phòng',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
