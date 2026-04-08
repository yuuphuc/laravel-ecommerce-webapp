<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('productimgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('productid');
            $table->string('fileName');
            $table->timestamps();

            $table->foreign('productid')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productimgs');
    }
};
