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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                // tạo ra thuộc tính id (primary key) - tự đong tang, kiểu unsigned biginteger
                $table->id();
                // tạo ra thuoc tinh proname - kiểu varchar- độ dai 100
                $table->string('proname', 100);
                // tạo ra thuoc tinh price - kiểu integer
                $table->integer('price');
                // tạo ra thuoc tinh proname - kiểu varchar- đo dai 300 , cho phep NULL    
                $table->string('description', 300)->nullable();
                // tạo ra thuoc tính fileName - kiểu string, cho phep NULL   
                $table->string('fileName')->nullable();
                // tạo thuộc tính status 
                $table->tinyInteger('status')->default(1);
                // tạo ra thuoc tinh cateid - kiểu unsigned integer    
                $table->unsignedInteger('cateid');
                // tạo ra thuoc tinh brandid - kiểu unsigned integer
                $table->unsignedInteger('brandid')->nullable();

                // tạo ra 2 thuoc tinh created_at va updated_at - kiểu timestamp, cho phep NULL    
                $table->timestamps();


                // khóa ngoại
                // đặt tên cho khoa categories_cateid_foreign    
                $table->foreign('cateid', 'fk_products_cateid')
                    ->references('cateid')->on('categories')
                    ->onDelete('restrict');
                // đặt tên cho khoa brands_cateid_foreign    
                $table->foreign('brandid', 'fk_products_brandid')
                    ->references('id')->on('brands')
                    ->onDelete('set null');
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('fk_products_cateid');
            $table->dropForeign('fk_products_brandid');
        });

        Schema::dropIfExists('products');
    }
};
