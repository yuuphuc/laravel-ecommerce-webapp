<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                // tạo ra thuộc tính cateid (primary key) - tự động tang, kiểu unsigned integer
                $table->increments('cateid');
                // tạo ra thuoc tinh catename - kiểu varchar- độ dai 100
                $table->string('catename', 100);
                //tạo ra thuộc tính description 
                $table->string('description', 255)->nullable();
                // tạo ra thuộc tính status - kiểu tinyint
                $table->boolean('status')->default(1);
                // tạo ra 2 thuoc tinh created_at va updated_at - kieu timestamp, NULL
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
