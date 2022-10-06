<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'author_id' => 1,
            'customer_name' => 'Merle Brandell',
            'customer_email' => 'merle@gmail.com',
            'shipping_first_name' => 'Michael',
            'shipping_last_name' => 'Andrew',
            'shipping_street_1' => 'Blablabla',
            'shipping_city' => 'Sacramento',
            'shipping_state' => 'CA',
            'shipping_postcode' => '11111',
            'shipping_country' => 'US',
            'billing_first_name' => 'Michael',
            'billing_last_name' => 'Andrew',
            'billing_street_1' => 'Blablabla',
            'billing_city' => 'Sacramento',
            'billing_state' => 'CA',
            'billing_postcode' => '11111',
            'billing_country' => 'US',
            'billing_phone' => '11111',
            'billing_email' => 'andrew@gmail.com',
            'shipping_method' => 'Flat rate',
            'payment_method' => 'Cash on Delivery',
            'shipping_cost' => 10.00,
            'order_total_price' => 903.00,
            'order_total_qty' => 6,
            'status' => 'processing'
        ]);
    }
}
