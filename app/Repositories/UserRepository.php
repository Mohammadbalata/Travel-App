<?php

namespace App\Repositories;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserRepository
{
    public function createUser($userData,$provider){
        return User::create([
            'name' => $userData->name,
            'email' => $userData->email,
            'password' => Hash::make(Str::random(8)),
            'provider' => $provider,
            'provider_id' => $userData->id,
            'provider_token' => $userData->token,
        ]);
    }

    public function getUserByProvider($userData,$provider){
        return User::where([
            'provider' => $provider,
            'provider_id' => $userData->id
        ])->first();
    }
}