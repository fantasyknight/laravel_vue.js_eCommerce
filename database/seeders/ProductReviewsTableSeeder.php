<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductReview;

class ProductReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductReview::create([
            'product_id' => 1,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 5,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 10,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 5,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 14,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 3,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 23,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 4,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 33,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 5,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 43,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 2,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 44,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 5,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);

        ProductReview::create([
            'product_id' => 52,
            'author_name' => 'John Doe',
            'author_email' => 'Joe@gmail.com',
            'rating' => 5,
            'content' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est.',
            'approved' => 1
        ]);
    }
}
