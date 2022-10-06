<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'media_id' => 1,
        ]);

        Category::create([
            'name' => 'Accessories',
            'slug' => 'accessories',
        ]);

        Category::create([
            'name' => 'Watches',
            'slug' => 'watches',
            'media_id' => 2,
            'parent' => 4,
        ]);

        Category::create([
            'name' => 'Caps',
            'slug' => 'caps',
            'parent' => 4,
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'media_id' => 5,
        ]);

        Category::create([
            'name' => 'Furniture',
            'slug' => 'furniture',
            'media_id' => 3,
        ]);

        Category::create([
            'name' => 'Music',
            'slug' => 'music',
            'media_id' => 6,
        ]);

        Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'media_id' => 4,
        ]);

        Category::create([
            'name' => 'Bag',
            'slug' => 'bag',
            'parent' => 4
        ]);

        Category::create([
            'name' => 'Articles',
            'slug' => 'articles',
            'type' => 'post'
        ]);

        Category::create([
            'name' => 'Bag',
            'slug' => 'bag',
            'type' => 'post'
        ]);

        Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'type' => 'post'
        ]);

        Category::create([
            'name' => 'Model',
            'slug' => 'model',
            'type' => 'post'
        ]);

        Category::create([
            'name' => 'Travel',
            'slug' => 'travel',
            'type' => 'post'
        ]);
    }
}
