<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'fullname' => 'Nguyễn Văn A',
                'tel' => '0901000001',
                'address' => 'Hà Nội',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Trần Thị B',
                'tel' => '0901000002',
                'address' => 'TP. Hồ Chí Minh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Lê Văn C',
                'tel' => '0901000003',
                'address' => 'Đà Nẵng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Phạm Thị D',
                'tel' => '0901000004',
                'address' => 'Cần Thơ',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Đỗ Văn E',
                'tel' => '0901000005',
                'address' => 'Hải Phòng',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Ngô Thị F',
                'tel' => '0901000006',
                'address' => 'Bình Dương',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Hoàng Văn G',
                'tel' => '0901000007',
                'address' => 'Đắk Lắk',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Vũ Thị H',
                'tel' => '0901000008',
                'address' => 'Huế',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Bùi Văn I',
                'tel' => '0901000009',
                'address' => 'Nghệ An',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fullname' => 'Trịnh Thị J',
                'tel' => '0901000010',
                'address' => 'Quảng Ninh',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
