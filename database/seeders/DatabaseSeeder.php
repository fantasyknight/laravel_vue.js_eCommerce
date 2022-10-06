<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Database\Seeders\UsersTableSeeder::class);
        $this->call(Database\Seeders\MediaTableSeeder::class);
        $this->call(Database\Seeders\CategoriesTableSeeder::class);
        $this->call(Database\Seeders\TagsTableSeeder::class);

        // products
        $this->call(Database\Seeders\ProductsTableSeeder::class);
        $this->call(Database\Seeders\AttributesTableSeeder::class);
        $this->call(Database\Seeders\AttributeTermsTableSeeder::class);
        $this->call(Database\Seeders\ProductAttributesTableSeeder::class);
        $this->call(Database\Seeders\ProductCategoriesTableSeeder::class);
        $this->call(Database\Seeders\ProductMediaTableSeeder::class);
        $this->call(Database\Seeders\ProductTermsTableSeeder::class);
        $this->call(Database\Seeders\ProductTagsTableSeeder::class);
        $this->call(Database\Seeders\ProductFilesTableSeeder::class);
        $this->call(Database\Seeders\ProductReviewsTableSeeder::class);

        // posts
        $this->call(Database\Seeders\PostsTableSeeder::class);
        $this->call(Database\Seeders\PostCommentsTableSeeder::class);
        $this->call(Database\Seeders\PostCategoriesTableSeeder::class);
        $this->call(Database\Seeders\PostMediaTableSeeder::class);
        $this->call(Database\Seeders\PostTagsTableSeeder::class);

        // shipping
        $this->call(Database\Seeders\ShippingZonesTableSeeder::class);
        $this->call(Database\Seeders\ShippingZoneMethodsTableSeeder::class);
        $this->call(Database\Seeders\ShippingLocationsTableSeeder::class);

        $this->call(Database\Seeders\CouponsTableSeeder::class);
        $this->call(Database\Seeders\OrdersTableSeeder::class);
        $this->call(Database\Seeders\OrderItemsTableSeeder::class);
        $this->call(Database\Seeders\OrderCouponsTableSeeder::class);

        // tax
        $this->call(Database\Seeders\TaxRatesTableSeeder::class);
    }
}
