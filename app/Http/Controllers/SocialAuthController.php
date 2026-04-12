<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $ex) {
            return redirect()->route('login')->with('error', $ex->getMessage());
        }

        $user = User::where('google_id', $googleUser->getId())
        ->orWhere('email', $googleUser->getEmail())->first();

        if($user){
            $user->update(['google_id'=> $googleUser->getId()]);
        }else{
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password'  => null,
            ]);
        }

        Auth::login($user);
        return redirect()->route('products.index');
    }
}
