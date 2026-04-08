<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItems = [];

        // Giả lập mỗi đơn hàng có từ 1-3 sản phẩm ngẫu nhiên
        for ($orderId = 1; $orderId <= 10; $orderId++) {
            $itemCount = rand(1, 3); // số sản phẩm trong 1 đơn
            $productIds = array_rand(range(1, 10), $itemCount); // chọn ngẫu nhiên các productid

            // Nếu chỉ chọn 1 id thì biến thành mảng 1 phần tử
            if (!is_array($productIds)) {
                $productIds = [$productIds];
            }

            foreach ($productIds as $pidIndex) {
                $productId = $pidIndex + 1; // vì array_rand trả về index
                $quantity = rand(1, 5);
                $price = rand(100000, 500000); // giá giả lập

                $orderItems[] = [
                    'orderid' => $orderId,
                    'productid' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::table('orderitems')->insert($orderItems);
    }
}
