<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingZoneMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_zone_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shipping_zone_id');
            $table->string('name');
            $table->string('type');
            $table->string('tax_status')->default('taxable');
            $table->decimal('cost', 8, 2)->default(0);
            $table->string('free_shipping_requirement')->nullable();
            $table->integer('minimum_order_amount')->nullable();
            $table->boolean('enabled')->default(true);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('shipping_zone_methods');
    }
}
