<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attribute::create([
            'name' => 'Color',
            'slug' => 'color'
        ]);

        Attribute::create([
            'name' => 'Size',
            'slug' => 'size'
        ]);
    }
}
