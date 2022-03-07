<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Mail\OrderInvoiceMail;
use App\Models\BillingInfo;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderPurchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        Customer::find($customer)->update([
            'customer_firstname' => $request->firstname,
            'customer_lastname' => $request->lastname,
            'customer_phone_number' => $request->phone_number
        ]);
        $billing = BillingInfo::insertGetId([
            'customer_id' => $customer,
            'customer_company_name' => $request->company_name,
            'customer_country' => $request->country,
            'street_address' => $request->street,
            'appertment_others' => $request->appartment,
            'town_city' => $request->city,
            'state_country' => $request->state,
            'zip_code' => $request->zip,
            'order_notes' => $request->order_notes,
            'created_at' => Carbon::now()
        ]);
        try{
            if($billing){
                $orderPurchase = OrderPurchase::insertGetId([
                    'customer_id' => $customer,
                    'billing_id' => $billing,
                    'payment_type' => $request->payment_method,
                    'created_at' => Carbon::now(),
                ]);
                if($orderPurchase){
                    $cart_customer_id = Cart::where('customer_id',$customer)->get();
    
                    foreach($cart_customer_id as $cart_item){
                        $arr['customer_id'] = $customer;
                        $arr['order_purchase_id'] = $orderPurchase;
                        $arr['billing_id'] = $billing;
                        $arr['product_id'] = $cart_item->product_id;
                        $arr['qty'] = $cart_item->qty;
                        OrderDetails::create($arr);
                    }
    
    
                    foreach($cart_customer_id as $ccid){
                        $ccid->delete();
                    }
    
                    $last_billing = BillingInfo::find($billing);
                    $order_detail = OrderDetails::where('customer_id', $customer)->get();
                    
                    Mail::to($request->email)->send(new OrderInvoiceMail($order_detail,$last_billing));
                    return redirect('/customer/dashboard')->with('orderDone','Your Order has been placed successfully.');
                }
            }
        }catch(Exception $e){
            return back();
        }
       
        // $customer = session('LoggedCustomer');
        // $cart_id = Cart::where('customer_id', $customer)->get();

       
    }
}
