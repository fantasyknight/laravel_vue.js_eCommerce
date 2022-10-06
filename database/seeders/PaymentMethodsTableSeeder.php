<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodDetail;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'Stripe',
            'slug' => 'stripe',
            'enabled' => true
        ]);

        PaymentMethod::create([
            'name' => 'Paypal',
            'slug' => 'paypal',
            'description' => 'Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.',
            'enabled' => true
        ]);

        PaymentMethod::create([
            'name' => 'Cash on Delivery',
            'slug' => 'cash_on_delivery',
            'description' => 'Have your customers pay with cash (or by other means) upon delivery.',
            'enabled' => true
        ]);

        PaymentMethodDetail::create([
            'payment_method_id' => 1,
            'meta' => 'environment',
            'value' => 'live'
        ]);

        PaymentMethodDetail::create([
            'payment_method_id' => 1,
            'meta' => 'secret_key',
            'value' => '123456'
        ]);

        PaymentMethodDetail::create([
            'payment_method_id' => 1,
            'meta' => 'publishable_key',
            'value' => '123456'
        ]);

        PaymentMethodDetail::create([
            'payment_method_id' => 2,
            'meta' => 'environment',
            'value' => 'production'
        ]);

        PaymentMethodDetail::create([
            'payment_method_id' => 2,
            'meta' => 'public_key',
            'value' => '123456'
        ]);
    }
}
