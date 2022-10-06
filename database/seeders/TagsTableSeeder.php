<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create([
            'name' => 'Bag',
            'slug' => 'bag',
        ]);

        Tag::create([
            'name' => 'Black',
            'slug' => 'black',
        ]);

        Tag::create([
            'name' => 'Blue',
            'slug' => 'blue',
        ]);

        Tag::create([
            'name' => 'Clothes',
            'slug' => 'clothes',
        ]);

        Tag::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
        ]);

        Tag::create([
            'name' => 'Hub',
            'slug' => 'hub',
        ]);

        Tag::create([
            'name' => 'Shirt',
            'slug' => 'shirt',
        ]);

        Tag::create([
            'name' => 'Shoes',
            'slug' => 'shoes',
        ]);

        Tag::create([
            'name' => 'Skirt',
            'slug' => 'skirt',
        ]);

        Tag::create([
            'name' => 'Sports',
            'slug' => 'sports',
        ]);

        Tag::create([
            'name' => 'Sweater',
            'slug' => 'sweater',
        ]);

        Tag::create([
            'name' => 'Strong',
            'slug' => 'strong',
        ]);

        Tag::create([
            'name' => 'Women',
            'slug' => 'women',
        ]);

        Tag::create([
            'name' => 'Song',
            'slug' => 'song'
        ]);
    }
}
