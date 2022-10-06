<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_files')->insert([
            [
                'product_id' => 14,
                'media_id' => 21,
                'name' => 'product-59-1',
            ],
            [
                'product_id' => 14,
                'media_id' => 23,
                'name' => 'product-61',
            ],
            [
                'product_id' => 42,
                'media_id' => 27,
                'name' => 'product-74',
            ],
            [
                'product_id' => 44,
                'media_id' => 32,
                'name' => 'product-82',
            ]
        ]);
    }
}
