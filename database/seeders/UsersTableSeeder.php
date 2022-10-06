<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Michael',
            'last_name' => 'Andrew',
            'email' => 'andrew@gmail.com',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi, vitae mattis nulla ante id dui.'
        ]);

        User::create([
            'first_name' => 'Merle',
            'last_name' => 'Brandell',
            'email' => 'merle@gmail.com',
            'password' => bcrypt('merle'),  
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi, vitae mattis nulla ante id dui.',
            'sign_up' => date("Y-m-d H:i:s")
        ]);

        User::create([
            'first_name' => 'Joe',
            'last_name' => 'Anita',
            'email' => 'anita@gmail.com',
            'password' => bcrypt('anita'),
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim ornare nisi, vitae mattis nulla ante id dui.',
            'billing_first_name' => 'Joe',
            'billing_last_name' => 'Anita',
            'billing_company' => 'blabla',
            'billing_address_1' => 'blabla',
            'billing_city' => 'blabla',
            'billing_state' => 'CA',
            'billing_postcode' => '11111',
            'billing_country' => 'US',
            'billing_email' => 'anita@gmail.com',
            'billing_phone' => '11111',
            'sign_up' => date('Y-m-d H:i:s'),
        ]);
    }
}
