<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingLocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_locations')->insert([
            [
                'shipping_zone_id' => 1,
                'code' => 'state:US:CA',
                'name' => 'California',
                'type' => 'state'
            ]
        ]);
    }
}
