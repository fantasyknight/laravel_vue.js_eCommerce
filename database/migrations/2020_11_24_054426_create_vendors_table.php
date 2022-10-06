<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('store_name')->nullable();
            $table->integer('user_id');
            $table->string('phone')->nullable();
            $table->text('toc')->nullable();
            $table->integer('banner_image')->nullable();
            $table->integer('profile_image')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('street')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->boolean('enable_add_product')->default(true);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->float('balance', 8, 2)->default(0);
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
        Schema::dropIfExists('vendors');
    }
}
