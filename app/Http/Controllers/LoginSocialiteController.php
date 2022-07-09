<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Redirect;



class LoginSocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleCallbackgoogle()
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('/');
            } else {
                $newUser = new User();

                $newUser->fill([
                    'hoTen' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => '',
                    'soDienThoai' => '',
                    'phan_quyen_id' => '2',
                    'anhDaiDien' => $user->avatar,
                    'diaChi' => '',
                ]);
                $newUser->save();


                $newUser->email_verified_at = now();
                $newUser->save();
                Auth::login($newUser);

                return redirect()->intended('/');
            }
        } catch (Exception $e) {
            return Redirect::route('user.login')->withErrors('Đăng nhập thất bại');
        }
    }
    public function redirectToFB()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleCallbackFB()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return Redirect::route('home');
            } else {
                $newUser = User::create([
                    'hoTen' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'facebook',
                    'password' => '',
                    'soDienThoai' => '',
                    'phan_quyen_id' => '2',
                    'anhDaiDien' => $user->avatar,
                    'diaChi' => '',
                ]);

                Auth::login($newUser);

                return Redirect::route('home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
