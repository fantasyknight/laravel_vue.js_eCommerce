<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->insert([
            [
                'product_id' => 1,
                'category_id' => 10
            ],
            [
                'product_id' => 1,
                'category_id' => 9
            ],
            [
                'product_id' => 5,
                'category_id' => 4
            ],
            [
                'product_id' => 5,
                'category_id' => 7
            ],
            [
                'product_id' => 10,
                'category_id' => 4
            ],
            [
                'product_id' => 10,
                'category_id' => 7
            ],
            [
                'product_id' => 14,
                'category_id' => 9
            ],
            [
                'product_id' => 14,
                'category_id' => 10
            ],
            [
                'product_id' => 15,
                'category_id' => 11
            ],
            [
                'product_id' => 15,
                'category_id' => 7
            ],
            [
                'product_id' => 19,
                'category_id' => 5
            ],
            [
                'product_id' => 19,
                'category_id' => 7
            ],
            [
                'product_id' => 19,
                'category_id' => 10
            ],
            [
                'product_id' => 23,
                'category_id' => 11
            ],
            [
                'product_id' => 23,
                'category_id' => 4
            ],
            [
                'product_id' => 28,
                'category_id' => 7
            ],
            [
                'product_id' => 28,
                'category_id' => 3
            ],
            [
                'product_id' => 33,
                'category_id' => 7
            ],
            [
                'product_id' => 38,
                'category_id' => 4
            ],
            [
                'product_id' => 38,
                'category_id' => 3
            ],
            [
                'product_id' => 42,
                'category_id' => 7
            ],
            [
                'product_id' => 43,
                'category_id' => 4
            ],
            [
                'product_id' => 44,
                'category_id' => 7
            ],
            [
                'product_id' => 45,
                'category_id' => 11
            ],
            [
                'product_id' => 46,
                'category_id' => 5
            ],
            [
                'product_id' => 46,
                'category_id' => 7
            ],
            [
                'product_id' => 47,
                'category_id' => 8
            ],
            [
                'product_id' => 51,
                'category_id' => 9
            ],
            [
                'product_id' => 51,
                'category_id' => 10
            ],
            [
                'product_id' => 51,
                'category_id' => 7
            ],
            [
                'product_id' => 52,
                'category_id' => 3
            ],
            [
                'product_id' => 52,
                'category_id' => 7
            ],
            [
                'product_id' => 56,
                'category_id' => 10
            ],
            [
                'product_id' => 57,
                'category_id' => 7
            ],
            [
                'product_id' => 57,
                'category_id' => 11
            ]
        ]);
    }
}
