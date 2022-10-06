<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('type')->default('simple');
            $table->boolean('enabled')->default(true);
            $table->longText('description')->nullable();
            $table->text('short_desc')->nullable();
            $table->string('excerpt')->nullable();
            $table->integer('parent')->default(0);
            $table->float('price', 8, 2)->nullable();
            $table->float('sale_price', 8, 2)->nullable();
            $table->boolean('sale_schedule')->default(false);
            $table->date('sale_start')->nullable();
            $table->date('sale_end')->nullable();
            $table->integer('tax_type_id')->default(1);
            $table->string('tax_status')->default('taxable');
            $table->string('sku')->nullable();
            $table->boolean('manage_stock')->default(false);
            $table->integer('stock_quantity')->nullable();
            $table->string('allow_backorder')->default('no');
            $table->string('stock_status')->default('in-stock');
            $table->integer('low_stock_threshold')->default(2);
            $table->boolean('sold_individually')->default(false);
            $table->integer('weight')->nullable();
            $table->integer('height')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->string('upsells')->nullable();
            $table->string('cross_sells')->nullable();
            $table->text('purchase_note')->nullable();
            $table->integer('menu_order')->nullable();
            $table->boolean('enable_reviews')->default(true);
            $table->boolean('downloadable')->default(false);
            $table->boolean('virtual')->default(false);
            $table->string('product_status')->default('draft');
            $table->boolean('featured')->default(false);
            $table->integer('author_id')->default(1);
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
        Schema::dropIfExists('products');
    }
}
