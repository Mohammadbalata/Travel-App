<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SocialLoginService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{
    // protected $socialLoginService;
    public function __construct(protected SocialLoginService $socialLoginService){
        $this->socialLoginService = $socialLoginService;
    }
    public function redirect($provider)
    {
        return $this->socialLoginService->redirect($provider);
    }

    public function callback($provider)
    {
        return $this->socialLoginService->callback($provider);
       
    }
}
