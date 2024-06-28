<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropOrderNewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('shipping_id');
            $table->unsignedBigInteger('total_amount');
            $table->enum('status', ['ORDERED', 'PROCESSING', 'SHIPPED', 'DELIVERED', 'CANCELLED']);
            $table->enum('cancellation_reason', ['THAY_DOI_DIA_CHI', 'THAY_DOI_SAN_PHAM', 'VAN_DE_THANH_TOAN', 'TIM_THAY_LUA_CHON_TOT_HON', 'KHONG_CO_NHU_CAU', 'HET_HANG', 'LY_DO_KHAC'])->nullable();
            $table->enum('payment_method', ['CHUYEN_KHOAN_NGAN_HANG', 'THANH_TOAN_KHI_NHAN_HANG']);
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customer')->onDelete('cascade');
            $table->foreign('shipping_id')->references('shipping_id')->on('shipping')->onDelete('cascade');
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
