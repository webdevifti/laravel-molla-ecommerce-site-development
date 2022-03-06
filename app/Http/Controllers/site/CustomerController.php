<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Models\BillingInfo;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderPurchase;
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
            'signinemail' => 'required',
            'signinpassword' => 'required'
        ]);

        $cutomer_info = Customer::where('customer_email', $request->signinemail)->orWhere('customer_username',$request->signinemail)->first();

        if(!$cutomer_info){
            return back()->with('login_email_error','Email or Username does not match');
        }else{
            if(Hash::check($request->signinpassword, $cutomer_info->customer_password)){
                $request->session()->put('LoggedCustomer', $request->signinemail);

                if($request->remember_check == null){
                    setcookie('customer_email',$request->signinemail,time()+10);
                }else{
                    setcookie('customer_email', $request->signinemail,time()+60*60*24*30);
                    return redirect('/');
                }

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
        $orders = OrderPurchase::where('customer_id',$customer->id)->get();
        $orderDetails = OrderDetails::where('customer_id', $customer->id)->get();
        return view('dashboard', compact('get_all_cats','customer','cart_data','orders','orderDetails'));
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

    public function accountUpdate(Request $request, $id){
        $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'user_name' => 'string|max:255',
            'phone_number' => 'required|max:11'
        ]);

        $customer = Customer::find($id);
        // dd($customer);
        $customer->customer_firstname = $request->first_name;
        $customer->customer_lastname = $request->last_name;
        $customer->customer_username = $request->user_name;
        $customer->customer_phone_number = $request->phone_number;
        $customer->save();

        return back()->with('updated','Save Changed');
    }
}
