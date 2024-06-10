<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('product_variant_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('size_id');
            $table->unsignedBigInteger('color_id');
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('price');
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');
            $table->foreign('size_id')->references('size_id')->on('sizes')->onDelete('cascade');
            $table->foreign('color_id')->references('color_id')->on('colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
