<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrderDetailsNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('total_price');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('product_variant_id')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
