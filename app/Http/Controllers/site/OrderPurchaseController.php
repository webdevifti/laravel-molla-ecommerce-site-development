<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Mail\OrderInvoiceMail;
use App\Models\BillingInfo;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\OrderDetails;
use App\Models\OrderPurchase;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\RequestStack;

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
            if($billing){
                $orderPurchase = OrderPurchase::insertGetId([
                    'customer_id' => $customer,
                    'orderTrackingID' => '#'.rand(11111111,99999999),
                    'invoiceID' => rand(11,99).'-'.rand(11,99).'-'.rand(11,99),
                    'billing_id' => $billing,
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'pending',
                    'grand_total' => $request->grand_total,
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
                    // dd($last_billing->relWithCustomer->customer_lastname);
                    $order_detail = OrderDetails::where('customer_id', $customer)->where('order_purchase_id', $orderPurchase)->get();
                    foreach($cart_customer_id as $cart_item){
                        Product::where('id', $cart_item->product_id)->decrement('quantity',$cart_item->qty);
                    }
                     Mail::to($request->email)->send(new OrderInvoiceMail($order_detail,$last_billing));
 
                    return redirect('/customer/dashboard')->with('orderDone','Your Order has been placed successfully.');
                }
            }else{
                return back()->with('order_error','Order Can not complete');
            }
       
    }

    public function applyCoupon(Request $request){
        $coupon = Coupon::where('coupon_name', $request->coupon_code)->first();

        if($coupon != null){
            if($coupon->coupon_expire < Carbon::now()){
                return back()->with('expire_coupon','Coupon Code Expired');
            }else{
                
            }
        }else{
            return back()->with('invalid_coupon','Invalid Coupon Code');
        }
    }

    // public function getDownload()
    // {
    //     //PDF file is stored under project/public/download/info.pdf
    //     $file= public_path(). "/download/info.pdf";

    //     $headers = array(
    //             'Content-Type: application/pdf',
    //             );

    //     return Response::download($file, 'hi.pdf', $headers);
    // }
}
