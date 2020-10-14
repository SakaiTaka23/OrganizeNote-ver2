<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Rules\NoteID;


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
            'noteid' => ['required', 'string', 'max:16', 'regex:/^[0-9a-z_]*$/', 'unique:users,noteid', new NoteID],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'noteid' => $input['noteid'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
