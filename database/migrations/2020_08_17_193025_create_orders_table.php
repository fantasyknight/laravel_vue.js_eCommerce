<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->default(0);
            $table->string('customer_email');
            $table->string('customer_name');
            $table->integer('author_id')->default(1);
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_company')->nullable();
            $table->string('shipping_street_1');
            $table->string('shipping_street_2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_postcode');
            $table->string('shipping_country');
            $table->string('billing_first_name');
            $table->string('billing_last_name');
            $table->string('billing_company')->nullable();
            $table->string('billing_street_1');
            $table->string('billing_street_2')->nullable();
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_postcode');
            $table->string('billing_country');
            $table->string('billing_phone');
            $table->string('billing_email');
            $table->string('shipping_method')->nullable();
            $table->string('payment_method');
            $table->decimal('shipping_cost')->default(0);
            $table->decimal('shipping_tax')->default(0);
            $table->decimal('order_tax')->default(0);
            $table->decimal('order_total_price')->default(0);
            $table->decimal('order_refunded_price')->default(0);
            $table->integer('order_total_qty')->default(0);
            $table->string('status')->default('on-hold');
            $table->text('order_info')->nullable();
            $table->decimal('vendor_net')->default(0);
            $table->string('order_type')->default('order');         // order, refund, suborder
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
        Schema::dropIfExists('orders');
    }
}
