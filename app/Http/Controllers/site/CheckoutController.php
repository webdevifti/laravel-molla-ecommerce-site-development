<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    //

    public function index(){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            
        }else{
            $cart_data = [];
            
        }
        if($cart_data->count() == 0){
            return redirect('/cart');
        }else{

            $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
            return view('checkout', compact('cart_data','get_all_cats','customer'));
        }
    }


}
