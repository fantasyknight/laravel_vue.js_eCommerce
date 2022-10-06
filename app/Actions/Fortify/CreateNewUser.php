<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::firstWhere('email', $input['email']);

        if ($user) {
            $user->password && abort(422, 'User already exists.');
            $user->forceFill([
                'password' => Hash::make($input['password']),
                'sign_up' => date("Y-m-d H:i:s"),
                'last_active' => date("Y-m-d H:i:s")
            ])->save();
        } else {
            $user = User::create([
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'sign_up' => date("Y-m-d H:i:s"),
                'last_active' => date("Y-m-d H:i:s")
            ]);
        }

        if ($input['role'] === 'vendor') {
            $user->forceFill([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'role_id' => 4
            ])->save();
            Vendor::create([
                'user_id' => $user->id,
                'street' => $input['street'],
                'country' => $input['country'],
                'state' => $input['state'],
                'store_name' => $input['store_name'],
                'paypal_email' => $input['paypal_email'],
                'city' => $input['city'],
                'phone' => $input['phone']
            ]);
        }

        return $user;
    }
}
