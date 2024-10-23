<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Khóa ngoại đến bảng orders
            $table->unsignedBigInteger('product_id'); // Khóa ngoại đến bảng products
            $table->integer('qty'); // Số lượng sản phẩm
            $table->integer('total', 0); // Tổng tiền cho sản phẩm (price * qty)
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_product');
    }
}
