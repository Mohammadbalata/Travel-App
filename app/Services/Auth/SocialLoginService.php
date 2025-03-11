<?php

namespace App\Services\Auth;

use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SocialLoginService 
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();

            $user = $this->userRepository->getUserByProvider($provider_user,$provider);

            if (!$user) {
                $user = $this->userRepository->createUser($provider_user,$provider);
            }
            
            Auth::login($user);

            return redirect()->route('home');

        } catch (Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => $e->getMessage(),
            ]);
        }
    }
}