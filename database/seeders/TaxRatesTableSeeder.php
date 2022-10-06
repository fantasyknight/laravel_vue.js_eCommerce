<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRate;

class TaxRatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxRate::create([
            'name' => 'west',
            'country' => 'US',
            'state' => 'CA',
            'postcode' => '11111',
            'rate' => 10,
            'is_shipping' => 0,
            'tax_type_id' => 1
        ]);
    }
}
