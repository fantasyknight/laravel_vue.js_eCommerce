<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_tag')->insert([
            [
                'product_id' => 1,
                'tag_id' => 5
            ],
            [
                'product_id' => 1,
                'tag_id' => 2
            ],
            [
                'product_id' => 5,
                'tag_id' => 2
            ],
            [
                'product_id' => 5,
                'tag_id' => 5
            ],
            [
                'product_id' => 10,
                'tag_id' => 1
            ],
            [
                'product_id' => 10,
                'tag_id' => 13
            ],
            [
                'product_id' => 14,
                'tag_id' => 13
            ],
            [
                'product_id' => 14,
                'tag_id' => 14
            ],
            [
                'product_id' => 15,
                'tag_id' => 10
            ],
            [
                'product_id' => 15,
                'tag_id' => 1
            ],
            [
                'product_id' => 19,
                'tag_id' => 2
            ],
            [
                'product_id' => 19,
                'tag_id' => 12
            ],
            [
                'product_id' => 23,
                'tag_id' => 13
            ],
            [
                'product_id' => 23,
                'tag_id' => 1
            ],
            [
                'product_id' => 23,
                'tag_id' => 2
            ],
            [
                'product_id' => 28,
                'tag_id' => 12
            ],
            [
                'product_id' => 28,
                'tag_id' => 8
            ],
            [
                'product_id' => 28,
                'tag_id' => 2
            ],
            [
                'product_id' => 33,
                'tag_id' => 10
            ],
            [
                'product_id' => 33,
                'tag_id' => 8
            ],
            [
                'product_id' => 38,
                'tag_id' => 4
            ],
            [
                'product_id' => 38,
                'tag_id' => 7
            ],
            [
                'product_id' => 42,
                'tag_id' => 11
            ],
            [
                'product_id' => 42,
                'tag_id' => 5
            ],
            [
                'product_id' => 42,
                'tag_id' => 9
            ],
            [
                'product_id' => 43,
                'tag_id' => 8
            ],
            [
                'product_id' => 43,
                'tag_id' => 3
            ],
            [
                'product_id' => 43,
                'tag_id' => 2
            ],
            [
                'product_id' => 43,
                'tag_id' => 10
            ],
            [
                'product_id' => 44,
                'tag_id' => 8
            ],
            [
                'product_id' => 44,
                'tag_id' => 2
            ],
            [
                'product_id' => 44,
                'tag_id' => 13
            ],
            [
                'product_id' => 46,
                'tag_id' => 2
            ],
            [
                'product_id' => 46,
                'tag_id' => 10
            ],
            [
                'product_id' => 47,
                'tag_id' => 6
            ],
            [
                'product_id' => 47,
                'tag_id' => 13
            ],
            [
                'product_id' => 51,
                'tag_id' => 14
            ],
            [
                'product_id' => 51,
                'tag_id' => 5
            ],
            [
                'product_id' => 51,
                'tag_id' => 2
            ],
            [
                'product_id' => 52,
                'tag_id' => 4
            ],
            [
                'product_id' => 52,
                'tag_id' => 12
            ],
            [
                'product_id' => 52,
                'tag_id' => 11
            ],
            [
                'product_id' => 56,
                'tag_id' => 14
            ],
            [
                'product_id' => 56,
                'tag_id' => 12
            ],
            [
                'product_id' => 57,
                'tag_id' => 3
            ],
            [
                'product_id' => 57,
                'tag_id' => 5
            ],
            [
                'product_id' => 57,
                'tag_id' => 1
            ]
        ]);
    }
}
