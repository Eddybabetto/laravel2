<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            "cf"=>"size:16|required",
            "tel"=>"regex:/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/|required"
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'surname' => $input['surname'],
            'cf' => $input['cf'],
            'tel' => $input['tel'],
            'admin' => false,
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
