<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
            'firstname' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'digits:11', 'max:255'],
            'designation' => ['required'],
            'role' => ['required'],
            'line_manager' => ['required'],
            'over_limit_approver' => ['required'],
            'sap_id' => ['required'],
            'joining_date' => ['required'],
            'base_town' => ['required'],
            'zone' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();


        return User::create([

            // 'profile_photo_path' => $imageName,
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'phone_number' => $input['phone_number'],
            'designation' => $input['designation'],
            'role' => $input['role'],
            'line_manager' => $input['line_manager'],
            'over_limit_approver' => $input['over_limit_approver'],
            'sap_id' => $input['sap_id'],
            'joining_date' => $input['joining_date'],
            'base_town' => $input['base_town'],
            'zone' => $input['zone'],
            'address' => $input['address'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
