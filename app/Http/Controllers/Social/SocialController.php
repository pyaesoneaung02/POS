<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //redirect to social login
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    //callback from social login
    public function callback($provider)
    {
        $socialInfo = Socialite::driver($provider)->user();
        $user = User::updateOrCreate([
            'provider_id' => $socialInfo->id,
        ], [
            'name' => $socialInfo->name,
            'nickname' => $socialInfo->nickname,
            'email' => $socialInfo->email,
            'provider' => $provider,
            'role' => 'user',
            'provider_token'=>$socialInfo->token,
        ]);

        Auth::login($user);

        return to_route('homePage');
    }
}
