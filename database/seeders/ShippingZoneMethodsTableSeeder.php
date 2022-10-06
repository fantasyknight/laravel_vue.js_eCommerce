<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingZoneMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_zone_methods')->insert([
            [
                'name' => 'Free shipping',
                'shipping_zone_id' => 1,
                'type' => 'free',
                'cost' => 0.00
            ],
            [
                'name' => 'Flat rate',
                'shipping_zone_id' => 1,
                'type' => 'flat',
                'cost' => 10.00
            ],
            [
                'name' => 'Local pickup',
                'shipping_zone_id' => 1,
                'type' => 'local',
                'cost' => 0.00
            ]
        ]);
    }
}
