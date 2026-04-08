<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
     {
        DB::table('orders')->insert([
            [
                'customerid' => 1,
                'orderdate' => '2025-07-10',
                'description' => 'Giao hàng trong giờ hành chính',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 2,
                'orderdate' => '2025-07-11',
                'description' => 'Ưu tiên đóng gói kỹ',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 3,
                'orderdate' => '2025-07-12',
                'description' => 'Giao tận nơi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 4,
                'orderdate' => '2025-07-13',
                'description' => 'Liên hệ trước khi giao',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 5,
                'orderdate' => '2025-07-14',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 6,
                'orderdate' => '2025-07-15',
                'description' => 'Đơn hàng lớn',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 7,
                'orderdate' => '2025-07-15',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 8,
                'orderdate' => '2025-07-16',
                'description' => 'Khách VIP',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 9,
                'orderdate' => '2025-07-17',
                'description' => 'Giao gấp',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'customerid' => 10,
                'orderdate' => '2025-07-18',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
