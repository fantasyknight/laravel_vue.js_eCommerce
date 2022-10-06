<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Shop Manager'
        ]);

        Role::create([
            'name' => 'Customer'
        ]);

        Role::create([
            'name' => 'Subscriber'
        ]);

        Role::create([
            'name' => 'Vendor'
        ]);

        Role::create([
            'name' => 'Author'
        ]);

        Role::create([
            'name' => 'Editor'
        ]);

        Role::create([
            'name' => 'Administrator'
        ]);

        Role::create([
            'name' => 'Observer'
        ]);
    }
}
