<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_media')->insert([
            [
                'post_id' => 1,
                'media_id' => 36
            ],
            [
                'post_id' => 2,
                'media_id' => 35
            ],
            [
                'post_id' => 3,
                'media_id' => 37
            ],
            [
                'post_id' => 4,
                'media_id' => 38
            ]
        ]);
    }
}
