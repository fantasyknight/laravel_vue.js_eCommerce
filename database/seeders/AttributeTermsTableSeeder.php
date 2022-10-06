<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttributeTerm;

class AttributeTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#000',
            'slug' => 'black'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#0188cc',
            'slug' => 'blue'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#ddb577',
            'slug' => 'brown'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#81d742',
            'slug' => 'green'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#6085a5',
            'slug' => 'indigo'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#d49cbf',
            'slug' => 'plum'
        ]);

        AttributeTerm::create([
            'attribute_id' => 1,
            'name' => '#ab6e6e',
            'slug' => 'red'
        ]);

        AttributeTerm::create([
            'attribute_id' => 2,
            'name' => 'XL',
            'slug' => 'xl'
        ]);

        AttributeTerm::create([
            'attribute_id' => 2,
            'name' => 'L',
            'slug' => 'l'
        ]);

        AttributeTerm::create([
            'attribute_id' => 2,
            'name' => 'M',
            'slug' => 'm'
        ]);

        AttributeTerm::create([
            'attribute_id' => 2,
            'name' => 'S',
            'slug' => 's'
        ]);

        AttributeTerm::create([
            'attribute_id' => 2,
            'name' => 'XS',
            'slug' => 'xs'
        ]);
    }
}
