<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('discount_type')->default('percent');
            $table->float('amount', 8, 2)->default(0);
            $table->boolean('free_shipping')->default(false);
            $table->date('expiry_date')->nullable();
            $table->integer('minimum_spend')->nullable();
            $table->integer('maximum_spend')->nullable();
            $table->boolean('individual_use')->default(false);
            $table->boolean('exclude_sale_items')->default(false);
            $table->string('products')->nullable();
            $table->string('exclude_products')->nullable();
            $table->string('categories')->nullable();
            $table->string('exclude_categories')->nullable();
            $table->integer('limit_per_coupon')->nullable();
            $table->integer('limit_x_items')->nullable();
            $table->integer('limit_per_user')->nullable();
            $table->string('allowed_emails')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
