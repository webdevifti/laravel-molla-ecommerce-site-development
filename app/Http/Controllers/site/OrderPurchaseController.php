<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\BillingInfo;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\OrderPurchase;
use Illuminate\Http\Request;

class OrderPurchaseController extends Controller
{
    //
    public function OrderPurchase(Request $request){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'country' => 'required',
            'street' => 'required',
            'appartment' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'payment_method' => 'required'
        ]);

        $customer = $request->customer_id;
        $billing = BillingInfo::insertGetId([
            'customer_id' => $customer,
            'customer_company_name' => $request->company_name,
            'customer_country' => $request->country,
            'street_address' => $request->street,
            'appertment_others' => $request->appartment,
            'town_city' => $request->city,
            'state_country' => $request->state,
            'zip_code' => $request->zip,
            'order_notes' => $request->order_notes
        ]);

        if($billing){
            $orderPurchase = OrderPurchase::create([
                'customer_id' => $customer,
                'billing_id' => $billing,
                // 'cart_id' => $cart_id,
                'payment_type' => $request->payment_method
            ]);
            if($orderPurchase){
                $cart_customer_id = Cart::where('customer_id',$customer)->get();
                foreach($cart_customer_id as $ccid){
                    $ccid->delete();
                }
                return redirect('/customer/dashboard')->with('orderDone','Your Order has been placed successfully.');
            }
        }
        // $customer = session('LoggedCustomer');
        // $cart_id = Cart::where('customer_id', $customer)->get();

       
    }
}
