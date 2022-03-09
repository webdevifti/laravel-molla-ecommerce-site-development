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
use Illuminate\Support\Facades\Response;
use PDF;
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
                    // dd($last_billing->relWithCustomer->customer_lastname);
                    $order_detail = OrderDetails::where('customer_id', $customer)->where('order_purchase_id', $orderPurchase)->get();
                    
                    $mail = Mail::to($request->email)->send(new OrderInvoiceMail($order_detail,$last_billing));

                    if($mail){

                        $pdf = PDF::loadView('invoice.invoice', compact('last_billing','order_detail'))->setPaper('a4', 'landscape')->setWarnings(false)->save('/download/customer_order_invoice.pdf')->stream();
                        return $pdf;
                    }
                

                    return redirect('/customer/dashboard')->with('orderDone','Your Order has been placed successfully.');
                }
            }else{
                return back()->with('order_error','Order Can not complete');
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
