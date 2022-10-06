<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Ultimate 3D Bluetooth Speaker',
            'slug' => 'ultimate-3d-blutooth-speaker',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0003-1',
            'featured' => 1
        ]);

        Product::create([
            'name' => 'Ultimate 3D Bluetooth Speaker - Plum, M',
            'slug' => 'ultimate-3d-blutooth-speaker',
            'excerpt' => '[{"attrId":1,"termId":6},{"attrId":2,"termId":10}]',
            'parent' => 1,
            'price' => 108,
            'sku' => 'PT0003-1'
        ]);

        Product::create([
            'name' => 'Ultimate 3D Bluetooth Speaker - Green, L',
            'slug' => 'ultimate-3d-blutooth-speaker',
            'excerpt' => '[{"attrId":1,"termId":4},{"attrId":2,"termId":9}]',
            'parent' => 1,
            'price' => 102,
            'sku' => 'PT0003-1'
        ]);

        Product::create([
            'name' => 'Ultimate 3D Bluetooth Speaker - Plum',
            'slug' => 'ultimate-3d-blutooth-speaker',
            'excerpt' => '[{"attrId":1,"termId":6},{"attrId":2,"termId":null}]',
            'parent' => 1,
            'price' => 105,
            'sku' => 'PT0003-1'
        ]);

        Product::create([
            'name' => 'Brown-Black Men Casual Glasses',
            'slug' => 'brown-black-men-casual-glasses',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0003'
        ]);

        Product::create([
            'name' => 'Brown-Black Men Casual Glasses - XL',
            'slug' => 'brown-black-men-casual-glasses',
            'excerpt' => '[{"attrId":2,"termId":8}]',
            'parent' => 5,
            'price' => 119,
            'sku' => 'PT0003'
        ]);

        Product::create([
            'name' => 'Brown-Black Men Casual Glasses - L',
            'slug' => 'brown-black-men-casual-glasses',
            'excerpt' => '[{"attrId":2,"termId":9}]',
            'parent' => 5,
            'price' => 130,
            'sku' => 'PT0003'
        ]);

        Product::create([
            'name' => 'Brown-Black Men Casual Glasses - M',
            'slug' => 'brown-black-men-casual-glasses',
            'excerpt' => '[{"attrId":2,"termId":10}]',
            'parent' => 5,
            'price' => 128,
            'sku' => 'PT0003'
        ]);

        Product::create([
            'name' => 'Brown-Black Men Casual Glasses - S',
            'slug' => 'brown-black-men-casual-glasses',
            'excerpt' => '[{"attrId":2,"termId":11}]',
            'parent' => 5,
            'price' => 121,
            'sku' => 'PT0003'
        ]);
        
        Product::create([
            'name' => 'Brown Women Casual HandBag',
            'slug' => 'brown-women-casual-handbag',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => '654111995-1-2',
            'weight' => 23,
            'height' => 65,
            'width' => 70,
            'length' => 12,
            'featured' => 1
        ]);

        Product::create([
            'name' => 'Brown Women Casual HandBag - Blue, XL',
            'slug' => 'brown-women-casual-handbag',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":8}]',
            'parent' => 10,
            'price' => 299,
            'sale_price' => 269,
            'sku' => 'PT234003'
        ]);

        Product::create([
            'name' => 'Brown Women Casual HandBag - Indigo, L',
            'slug' => 'brown-women-casual-handbag',
            'excerpt' => '[{"attrId":1,"termId":5},{"attrId":2,"termId":9}]',
            'parent' => 10,
            'price' => 259,
            'sale_price' => 209,
            'sku' => 'PT234003'
        ]);

        Product::create([
            'name' => 'Brown Women Casual HandBag - Blue',
            'slug' => 'brown-women-casual-handbag',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":null}]',
            'parent' => 10,
            'price' => 286,
            'sale_price' => 245,
            'sku' => 'PT234003'
        ]);

        Product::create([
            'name' => 'Circled Ultimate 3D Speaker',
            'slug' => 'circled-ultimate-3d-speaker',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0003',
            'price' => 299,
            'sale_price' => 260,
            'sale_schedule' => 1,
            'sale_end' => '2021-11-26',
            'sku' => '654111995-1-1-2',
            'weight' => 56,
            'height' => 34,
            'width' => 56,
            'length' => 23,
            'downloadable' => 1,
            'featured' => 1
        ]);

        Product::create([
            'name' => 'Blue Backpack for the Young',
            'slug' => 'blue-backpack-for-the-young',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0003-2'
        ]);

        Product::create([
            'name' => 'Blue Backpack for the Young - Plum, L',
            'slug' => 'blue-backpack-for-the-young',
            'excerpt' => '[{"attrId":1,"termId":6},{"attrId":2,"termId":9}]',
            'parent' => 15,
            'price' => 152,
            'sale_price' => 134,
        ]);

        Product::create([
            'name' => 'Blue Backpack for the Young - Brown, XL',
            'slug' => 'blue-backpack-for-the-young',
            'excerpt' => '[{"attrId":1,"termId":6},{"attrId":2,"termId":9}]',
            'parent' => 15,
            'price' => 125,
            'sale_price' => 123,
        ]);

        Product::create([
            'name' => 'Blue Backpack for the Young - S',
            'slug' => 'blue-backpack-for-the-young',
            'excerpt' => '[{"attrId":1,"termId":null},{"attrId":2,"termId":11}]',
            'parent' => 15,
            'price' => 145,
        ]);

        Product::create([
            'name' => 'Men Black Sports Watch',
            'slug' => 'men-black-sports-watch',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0007',
            'manage_stock' => 1,
            'stock_quantity' => 100,
            'featured' => 1,
        ]);

        Product::create([
            'name' => 'Men Black Sports Watch - Brown, S',
            'slug' => 'men-black-sports-watch',
            'excerpt' => '[{"attrId":1,"termId":3},{"attrId":2,"termId":11}]',
            'parent' => 19,
            'price' => 167,
            'sale_price' => 155
        ]);

        Product::create([
            'name' => 'Men Black Sports Watch - Green, M',
            'slug' => 'men-black-sports-watch',
            'excerpt' => '[{"attrId":1,"termId":4},{"attrId":2,"termId":10}]',
            'parent' => 19,
            'price' => 145
        ]);

        Product::create([
            'name' => 'Men Black Sports Watch - XS',
            'slug' => 'men-black-sports-watch',
            'excerpt' => '[{"attrId":1,"termId":null},{"attrId":2,"termId":12}]',
            'parent' => 19,
            'price' => 168
        ]);

        Product::create([
            'name' => 'Women Casual Bag Spring',
            'slug' => 'women-casual-bag-spring',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0006',
            'manage_stock' => 1,
            'stock_quantity' => 10
        ]);

        Product::create([
            'name' => 'Women Casual Bag Spring - XL',
            'slug' => 'women-casual-bag-spring',
            'excerpt' => '[{"attrId":2,"termId":8}]',
            'parent' => 23,
            'price' => 165
        ]);

        Product::create([
            'name' => 'Women Casual Bag Spring - L',
            'slug' => 'women-casual-bag-spring',
            'excerpt' => '[{"attrId":2,"termId":9}]',
            'parent' => 23,
            'price' => 154
        ]);

        Product::create([
            'name' => 'Women Casual Bag Spring - M',
            'slug' => 'women-casual-bag-spring',
            'excerpt' => '[{"attrId":2,"termId":10}]',
            'parent' => 23,
            'price' => 147
        ]);

        Product::create([
            'name' => 'Women Casual Bag Spring - XS',
            'slug' => 'women-casual-bag-spring',
            'excerpt' => '[{"attrId":2,"termId":12}]',
            'parent' => 23,
            'price' => 153
        ]);

        Product::create([
            'name' => 'Gentle Casual Blue Shoes',
            'slug' => 'gentle-casual-blue-shoes',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0005',
            'manage_stock' => 1,
            'stock_quantity' => 10
        ]);

        Product::create([
            'name' => 'Gentle Casual Blue Shoes - Black, M',
            'slug' => 'gentle-casual-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":1},{"attrId":2,"termId":10}]',
            'parent' => 28,
            'price' => 59
        ]);

        Product::create([
            'name' => 'Gentle Casual Blue Shoes - Brown, L',
            'slug' => 'gentle-casual-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":3},{"attrId":2,"termId":9}]',
            'parent' => 28,
            'price' => 59
        ]);

        Product::create([
            'name' => 'Gentle Casual Blue Shoes - Green, S',
            'slug' => 'gentle-casual-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":4},{"attrId":2,"termId":11}]',
            'parent' => 28,
            'price' => 68
        ]);

        Product::create([
            'name' => 'Gentle Casual Blue Shoes - Blue',
            'slug' => 'gentle-casual-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":null}]',
            'parent' => 28,
            'price' => 57
        ]);

        Product::create([
            'name' => 'Basketball Sports Blue Shoes',
            'slug' => 'basketball-sports-blue-shoes',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0002',
        ]);

        Product::create([
            'name' => 'Basketball Sports Blue Shoes - Brown, S',
            'slug' => 'basketball-sports-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":3},{"attrId":2,"termId":11}]',
            'parent' => 33,
            'price' => 69
        ]);

        Product::create([
            'name' => 'Basketball Sports Blue Shoes - Indigo, XS',
            'slug' => 'basketball-sports-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":5},{"attrId":2,"termId":12}]',
            'parent' => 33,
            'price' => 62
        ]);

        Product::create([
            'name' => 'Basketball Sports Blue Shoes - Plum, L',
            'slug' => 'basketball-sports-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":6},{"attrId":2,"termId":9}]',
            'parent' => 33,
            'price' => 57
        ]);

        Product::create([
            'name' => 'Basketball Sports Blue Shoes - Blue',
            'slug' => 'basketball-sports-blue-shoes',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":null}]',
            'parent' => 33,
            'price' => 62
        ]);

        Product::create([
            'name' => 'Men Black Gentle Belt',
            'slug' => 'men-black-gentle-belt',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT0008',
            'featured' => 1
        ]);

        Product::create([
            'name' => 'Men Black Gentle Belt - Brown, M',
            'slug' => 'men-black-gentle-belt',
            'excerpt' => '[{"attrId":1,"termId":3},{"attrId":2,"termId":10}]',
            'parent' => 38,
            'price' => 89
        ]);

        Product::create([
            'name' => 'Men Black Gentle Belt - Green, L',
            'slug' => 'men-black-gentle-belt',
            'excerpt' => '[{"attrId":1,"termId":4},{"attrId":2,"termId":9}]',
            'parent' => 38,
            'price' => 81
        ]);

        Product::create([
            'name' => 'Men Black Gentle Belt - Blue',
            'slug' => 'men-black-gentle-belt',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":null}]',
            'parent' => 38,
            'price' => 77
        ]);

        Product::create([
            'name' => 'Men Belt Double Set',
            'slug' => 'men-belt-double-set',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'price' => 276,
            'sku' => '654111995-1-1-1',
            'weight' => 56,
            'height' => 34,
            'width' => 56,
            'length' => 23,
            'downloadable' => 1
        ]);

        Product::create([
            'name' => 'Men Black Sports Shoes',
            'slug' => 'men-black-sports-shoes',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'price' => 99,
            'sku' => '654111',
            'weight' => 34,
            'height' => 25,
            'width' => 74,
            'length' => 23,
        ]);

        Product::create([
            'name' => 'Casual Spring Blue Shoes',
            'slug' => 'casual-spring-blue-shoes',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'price' => 88,
            'sale_price' => 73,
            'sku' => '654111965',
            'weight' => 56,
            'height' => 34,
            'width' => 56,
            'length' => 23,
            'downloadable' => 1
        ]);

        Product::create([
            'name' => 'Men Sports Travel Bag',
            'slug' => 'men-sports-travel-bag',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'price' => 230,
            'sku' => '854613298',
            'weight' => 34,
            'height' => 25,
            'width' => 74,
            'length' => 23,
            'featured' => 1,
        ]);

        Product::create([
            'name' => 'Fashion Men Watch',
            'slug' => 'fashion-men-watch',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT230003',
            'price' => 342,
            'sale_price' => 312,
            'manage_stock' => 1,
            'stock_quantity' => 1,
            'stock_status' => 'out-of-stock',
            'weight' => 34,
            'height' => 25,
            'width' => 74,
            'length' => 23,
            'featured' => 1,
        ]);

        Product::create([
            'name' => 'Family Nice Chair',
            'slug' => 'family-nice-chair',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT02304308',
            'weight' => 34,
            'height' => 25,
            'width' => 74,
            'length' => 23
        ]);

        Product::create([
            'name' => 'Family Nice Chair - Brown, XL',
            'slug' => 'family-nice-chair',
            'excerpt' => '[{"attrId":1,"termId":3},{"attrId":2,"termId":8}]',
            'parent' => 47,
            'price' => 189
        ]);

        Product::create([
            'name' => 'Family Nice Chair - Green, M',
            'slug' => 'family-nice-chair',
            'excerpt' => '[{"attrId":1,"termId":4},{"attrId":2,"termId":10}]',
            'parent' => 47,
            'price' => 181
        ]);

        Product::create([
            'name' => 'Family Nice Chair - Black',
            'slug' => 'family-nice-chair',
            'excerpt' => '[{"attrId":1,"termId":1},{"attrId":2,"termId":null}]',
            'parent' => 47,
            'price' => 177
        ]);

        Product::create([
            'name' => 'Nice Stereo Headphone',
            'slug' => 'nice-stereo-headphone',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT43230003',
            'price' => 239,
            'sale_price' => 201,
            'weight' => 34,
            'height' => 25,
            'width' => 74,
            'length' => 23,
            'featured' => 1,
        ]);

        Product::create([
            'name' => 'Men Winter Coat',
            'slug' => 'men-winter-coat',
            'type' => 'variable',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT04308',
            'weight' => 4,
            'featured' => 1
        ]);

        Product::create([
            'name' => 'Men Winter Coat - Blue, L',
            'slug' => 'men-winter-coat',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":9}]',
            'parent' => 52,
            'price' => 543
        ]);

        Product::create([
            'name' => 'Men Winter Coat - M',
            'slug' => 'men-winter-coat',
            'excerpt' => '[{"attrId":1,"termId":null},{"attrId":2,"termId":10}]',
            'parent' => 52,
            'price' => 576
        ]);

        Product::create([
            'name' => 'Men Winter Coat - Blue, S',
            'slug' => 'men-winter-coat',
            'excerpt' => '[{"attrId":1,"termId":2},{"attrId":2,"termId":11}]',
            'parent' => 52,
            'price' => 526
        ]);

        Product::create([
            'name' => 'Computer Mouse',
            'slug' => 'computer-mouse',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT4305003',
            'price' => 56,
            'weight' => 2,
            'height' => 25,
            'width' => 74,
            'length' => 23
        ]);

        Product::create([
            'name' => 'Fashion Computer Bag',
            'slug' => 'fashion-computer-bag',
            'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat.</p><ul><li>Any Product types that You want - Simple, Configurable</li><li>Downloadable/Digital Products, Virtual Products</li><li>Inventory Management with Backordered items</li></ul><p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br /> quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
            'short_desc' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolre eu fugiat nulla pariatur excepteur sint occaecat cupidatat non. Duis aute irure dolor in reprehenderit in voluptate velit esse.',
            'sku' => 'PT43043003',
            'price' => 234,
            'sale_price' => 209,
            'weight' => 2,
            'height' => 25,
            'width' => 74,
            'length' => 23
        ]);
    }
}
