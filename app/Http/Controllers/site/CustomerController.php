<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    //

    public function index(){
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
       
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->get();
        }else{
            $cart_data = [];
        }
        return view('login', compact('get_all_cats','cart_data'));
    }

    public function login(Request $request){
        $request->validate([
            'singinemail' => 'required',
            'singinpassword' => 'required'
        ]);

        $cutomer_info = Customer::where('customer_email', $request->singinemail)->orWhere('customer_username',$request->singinemail)->first();

        if(!$cutomer_info){
            return back()->with('login_email_error','Email or Username does not match');
        }else{
            if(Hash::check($request->singinpassword, $cutomer_info->customer_password)){
                $request->session()->put('LoggedCustomer', $request->singinemail);
                return redirect('/');
            }else{
                return back()->with('password_error','Password is incorrect');
            }
        }
    }

    public function register(CustomerRegisterRequest $request){
        try{
            Customer::create([
                'customer_username' => $request->customer_username,
                'customer_email' => $request->customer_email,
                'customer_password' => Hash::make($request->password)
            ]);
            $request->session()->put('LoggedCustomer', $request->customer_email);
            return redirect('/')->with('customer_registered',"Your Registration has been successfully");
        }catch(Exception $e){
            return back()->with('customer_registered_fail',"Registration can not be done");

        }
       
    }

    public function customerDashboard(){
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $cutomer = $this->getLoggedCustomer();
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->get();
        }else{
            $cart_data = [];
        }
        return view('dashboard', compact('get_all_cats','customer','cart_data'));
    }

    public function getLoggedCustomer(){
        $logged_customer = session('LoggedCustomer');
        $logged_customer_data = Customer::where('customer_email',$logged_customer)->first();
        return $logged_customer_data;
    }

    public function logout(){
        if(session()->has('LoggedCustomer')){
            session()->pull('LoggedCustomer');
            return redirect('/');
        }
    }
}
