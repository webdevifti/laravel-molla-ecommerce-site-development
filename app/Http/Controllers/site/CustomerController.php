<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Mail\RegistrationMail;
use App\Models\BillingInfo;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderPurchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
                }
                return redirect('/');

            }else{
                return back()->with('password_error','Password is incorrect');
            }
        }
    }

    public function register(CustomerRegisterRequest $request){
      
            $customer = Customer::insertGetId([
                'customer_username' => $request->customer_username,
                'customer_email' => $request->customer_email,
                'customer_password' => Hash::make($request->password),
                'verification_code' => sha1(time()),
                'created_at' => Carbon::now(),
            ]);
            // $request->session()->put('LoggedCustomer', $request->customer_email);
            if($customer){
                $get_last_customer = Customer::find($customer);
                $mail_data = [
                    'email' => $request->customer_email,
                    'code' => $get_last_customer->verification_code,
                ];

                Mail::to($request->customer_email)->send(new RegistrationMail($mail_data));
                $request->session()->put('LoggedCustomer', $request->customer_email);
                return redirect('/customer/dashboard')->with('customer_registered',"Your Registration has been successfully");
            }else{

                return back()->with('customer_registered_fail',"Registration can not be done");
            }

    
       
    }

    public function verifyEmail(){
        $code = request()->query('code');
        $check_customer = Customer::where('verification_code',$code)->first();

        if($check_customer->verification_code != $code){
            return 'Unauthorized code';
        }else{
            $check_customer->is_verified = 'verified';
            $check_customer->save();
            return redirect('/');
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
       
        $orderPurchase = OrderPurchase::where('customer_id',$customer->id)->get();
        
        $orderDetails = OrderDetails::where('customer_id', $customer->id)->get();
        
        // dd($orderDetails);
        return view('dashboard', compact('get_all_cats','customer','cart_data','orderPurchase','orderDetails'));
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
            'phone_number' => 'required|max:11'
        ]);


        $customer = Customer::find($id);
        if($request->current_pass){
            if(Hash::check($request->current_pass, $customer->customer_password)){
                if($request->new_password != $request->confirm_new_pass){
                    return back()->with('both_pass_not_macth','Both Password not matching');
                }else{
                    $customer->customer_password = Hash::make($request->new_password);
                    $customer->save();

                    return back()->with('pass_changed','Password has been changed');
                }
            }else{
                return back()->with('current_pass_not_match','Your Current Password not matching');
            }
    
        }else{

            // dd($customer);
            $customer->customer_firstname = $request->first_name;
            $customer->customer_lastname = $request->last_name;
            $customer->customer_phone_number = $request->phone_number;
            $customer->save();
    
            return back()->with('updated','Save Changed');
        }

    }
}
