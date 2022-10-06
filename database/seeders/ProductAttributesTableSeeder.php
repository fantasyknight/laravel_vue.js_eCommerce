<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_attribute')->insert([
            [
                'product_id' => 1,
                'attribute_id' => 1,
                'term_ids' => '1,4,5,6',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 1,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 5,
                'attribute_id' => 1,
                'term_ids' => '2,3,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 5,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 10,
                'attribute_id' => 1,
                'term_ids' => '2,3,5',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 10,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 14,
                'attribute_id' => 1,
                'term_ids' => '4,6',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 14,
                'attribute_id' => 2,
                'term_ids' => '10,12',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 15,
                'attribute_id' => 1,
                'term_ids' => '1,3,6',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 15,
                'attribute_id' => 2,
                'term_ids' => '8,9,11,12',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 19,
                'attribute_id' => 1,
                'term_ids' => '3,4',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 19,
                'attribute_id' => 2,
                'term_ids' => '10,11,12',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 23,
                'attribute_id' => 1,
                'term_ids' => '3,4,6',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 23,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,12',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 28,
                'attribute_id' => 1,
                'term_ids' => '1,2,3,4',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 28,
                'attribute_id' => 2,
                'term_ids' => '9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 33,
                'attribute_id' => 1,
                'term_ids' => '2,3,5,6',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 33,
                'attribute_id' => 2,
                'term_ids' => '8,9,11,12',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 38,
                'attribute_id' => 1,
                'term_ids' => '2,3,4',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 38,
                'attribute_id' => 2,
                'term_ids' => '9,10,11,12',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 42,
                'attribute_id' => 1,
                'term_ids' => '1,3,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 42,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,12',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 43,
                'attribute_id' => 1,
                'term_ids' => '3,4,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 43,
                'attribute_id' => 2,
                'term_ids' => '8,10,11',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 44,
                'attribute_id' => 1,
                'term_ids' => '2,3,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 44,
                'attribute_id' => 2,
                'term_ids' => '9,10,11,12',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 45,
                'attribute_id' => 1,
                'term_ids' => '1,3,4,6',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 45,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,12',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 46,
                'attribute_id' => 1,
                'term_ids' => '2,3,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 46,
                'attribute_id' => 2,
                'term_ids' => '8,9,11',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 47,
                'attribute_id' => 1,
                'term_ids' => '1,3,4',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 47,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 51,
                'attribute_id' => 1,
                'term_ids' => '2,3,4,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 52,
                'attribute_id' => 1,
                'term_ids' => '1,2,3,5',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 52,
                'attribute_id' => 2,
                'term_ids' => '8,9,10,11',
                'used_for_variation' => 1
            ],
            [
                'product_id' => 56,
                'attribute_id' => 1,
                'term_ids' => '2,3,5',
                'used_for_variation' => 0
            ],
            [
                'product_id' => 57,
                'attribute_id' => 2,
                'term_ids' => '9,10,11,12',
                'used_for_variation' => 0
            ]
        ]);
    }
}
