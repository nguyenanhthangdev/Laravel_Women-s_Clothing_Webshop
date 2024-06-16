<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping', function (Blueprint $table) {
            $table->id('shipping_id');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone_number');
            $table->enum('address_type', ['HOME', 'OFFICE', 'NO']);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('customer_id');
            $table->text('address_specific');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('district_id');
            $table->unsignedBigInteger('ward_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('customer_id')->references('customer_id')->on('customer')->onDelete('cascade');
            $table->foreign('city_id')->references('city_id')->on('city')->onDelete('cascade');
            $table->foreign('district_id')->references('district_id')->on('district')->onDelete('cascade');
            $table->foreign('ward_id')->references('ward_id')->on('ward')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping');
    }
}
