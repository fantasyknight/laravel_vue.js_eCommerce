<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class BaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'parent' => -1,
            'type' => 'product'
        ]);

        Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'parent' => -1,
            'type' => 'post'
        ]);
    }
}
