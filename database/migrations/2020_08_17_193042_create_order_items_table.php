<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('parent_id');
            $table->string('name');
            $table->integer('qty');
            $table->decimal('net_revenue')->default(0);
            $table->decimal('gross_revenue')->default(0);
            $table->decimal('coupon_amount')->default(0);
            $table->decimal('tax_amount')->default(0);
            $table->decimal('shipping_amount')->default(0);
            $table->decimal('shipping_tax_amount')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
