<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_tag')->insert([
            [
                'post_id' => 1,
                'tag_id' => 18
            ],
            [
                'post_id' => 1,
                'tag_id' => 20
            ],
            [
                'post_id' => 1,
                'tag_id' => 15
            ],
            [
                'post_id' => 2,
                'tag_id' => 16
            ],
            [
                'post_id' => 2,
                'tag_id' => 19
            ],
            [
                'post_id' => 3,
                'tag_id' => 17
            ],
            [
                'post_id' => 3,
                'tag_id' => 15
            ],
            [
                'post_id' => 4,
                'tag_id' => 16
            ],
            [
                'post_id' => 4,
                'tag_id' => 18
            ]
        ]);
    }
}
