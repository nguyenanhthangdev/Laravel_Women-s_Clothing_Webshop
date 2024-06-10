<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id('product_id'); // Khóa chính
            $table->string('name'); // Tên sản phẩm
            $table->text('description')->nullable(); // Mô tả sản phẩm, có thể null
            $table->integer('discount')->nullable();
            $table->unsignedBigInteger('manufacturer_id'); // ID nhà sản xuất
            $table->foreign('manufacturer_id')->references('manufacturer_id')->on('manufacturers')->onDelete('cascade'); // Khóa ngoại
            $table->boolean('featured')->default(false);
            $table->boolean('new')->default(false);
            $table->boolean('best_seller')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps(); // Các cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
