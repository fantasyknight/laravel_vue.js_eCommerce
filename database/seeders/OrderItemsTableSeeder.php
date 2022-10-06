<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderItem::create([
            'order_id' => 1,
            'product_id' => 46,
            'parent_id' => 46,
            'name' => 'Fashion Men Watch',
            'qty' => 1,
            'net_revenue' => 312,
            'gross_revenue' => 312,
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 44,
            'parent_id' => 44,
            'name' => 'Casual Spring Blue Shoes',
            'qty' => 2,
            'net_revenue' => 146,
            'gross_revenue' => 146,
        ]);

        OrderItem::create([
            'order_id' => 1,
            'product_id' => 18,
            'parent_id' => 15,
            'name' => 'Blue Backpack for the Young - #ddb577, S',
            'qty' => 3,
            'net_revenue' => 435,
            'gross_revenue' => 435,
        ]);
    }
}
