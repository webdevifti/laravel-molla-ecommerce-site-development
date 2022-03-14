<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //
    public function facebookRedirect(){
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook(){
        $user = Socialite::driver('facebook')->stateless()->user();
        // dd($user);
        $findCustomer = Customer::where('social_login_id',$user->id)->first();
        // dd($findCustomer);
        if($findCustomer != null){
            session()->put('LoggedCustomer', $user->email);
            return redirect('/');
        }else{
            $customer = Customer::insert([
                'customer_username' => $user->name,
                'customer_email' => $user->email,
                'customer_password' => '1234567890',
                'verification_code' => sha1(time()),
                'social_login_id' => $user->id,
                'created_at' => Carbon::now(),
            ]);
            if($customer){
                session()->put('LoggedCustomer', $user->email);
                return redirect('/');
            }else{
                return redirect('/customer/auth');
            }
        }
    }

    public function googleRedirect(){
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle(){
        $user = Socialite::driver('google')->stateless()->user();
        // dd($user);
        // dd($user);
        $findCustomer = Customer::where('social_login_id',$user->id)->first();
        // dd($findCustomer);
        if($findCustomer != null){
            session()->put('LoggedCustomer', $user->email);
            return redirect('/');
        }else{
            $customer = Customer::insert([
                'customer_username' => $user->name,
                'customer_email' => $user->email,
                // 'customer_phone_number' => $user->phone_number,
                'customer_password' => '1234567890',
                'verification_code' => sha1(time()),
                'social_login_id' => $user->id,
                'created_at' => Carbon::now(),
            ]);
            if($customer){
                session()->put('LoggedCustomer', $user->email);
                return redirect('/');
            }else{
                return redirect('/customer/auth');
            }
        }
    }
}
