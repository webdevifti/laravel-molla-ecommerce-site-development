<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CartController extends Controller
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
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        return view('cart',compact('cart_data','get_all_cats'));
    }

    public function addToCart(Request $request){
        if(session('LoggedCustomer')){
           
            $get_customer = Customer::where('customer_email', session('LoggedCustomer'))->first();
            $get_last_cart_item = Cart::where('product_id',$request->product_id)->where('customer_id',$get_customer->id)->first();
            
            if($get_last_cart_item != null){
                return response()->json([
                    'error_to_cart' => 'This product is already in the cart'
                ]);
            }else{
                $add_cart = Cart::create([
                    'product_id' => $request->product_id,
                    'customer_id' => $get_customer->id,
                    'qty' => $request->product_qty
                ]);
                if($add_cart){
                   
                    return response()->json([
                        'added_to_cart' =>'Product added to your cart',
                        'cart_div' =>  $this->getCartproduct(),
                    ]);
                
                }else{
                    return response()->json([
                        'added_to_cart_error' => 'Something wrong'
                    ]);
                }
                    
            }
        }else{
            return redirect('/customer/auth')->with('fail', 'You have to login first');
        }
    }

    public function getCartproduct(){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            $cart_div = '';
           
            foreach($cart_data as $cart){
                $cart_div .= '<div class="product" id="cartItem_'.$cart->id.'">
                    <div class="product-cart-details">
                        <h4 class="product-title">
                            <a href="/product-detail/'.$cart->relCartToProduct->product_slug.'">'.$cart->relCartToProduct->product_title.'</a>
                        </h4>

                        <span class="cart-product-info">
                            <span class="cart-product-qty" id="drpcartqty_'.$cart->id.'">'.$cart->qty.'</span>
                            x BDT '.$cart->relCartToProduct->selling_price.'
                            

                            <p id="drpcart_subtotal_'.$cart->id.'">Sub total: '.$cart->relCartToProduct->selling_price*$cart->qty.'</p>
                        </span>
                    </div>

                    <figure class="product-image-container">
                        <a href="/product-detail/'.$cart->relCartToProduct->product_slug.'" class="product-image">
                            <img src="'.asset('uploads/products/previews/'.$cart->relCartToProduct->product_preview_img).'" alt="product">
                        </a>
                    </figure>
                    <button onclick="removeCart("","'.$cart->id.'")" class="btn-remove" title="Remove Product"><i class="icon-close"></i></button>
                </div>';
                
            }
            $total_priced = 0;
            foreach($cart_data as $cp){
                $total = $cp->relCartToProduct->selling_price*$cp->qty;
                $total_priced += $total;
            }
            $cart_div .= ' </div><div class="dropdown-cart-total"><span>Total</span><span class="cart-total-price" id="drptotal_price">BDT '.$total_priced.'</span>
            </div><div class="dropdown-cart-action">
                <a href="/cart" class="btn btn-primary">View Cart</a>
                <a href="/checkout" class="btn btn-outline-primary-2"><span>Checkout</span><i class="icon-long-arrow-right"></i></a>
            </div>';

            $total_price = 0;
            foreach($cart_data as $c){
                $total = $c->relCartToProduct->selling_price*$c->qty;
                $total_price += $total;
            }
                return response()->json([
                    'cart_data' => $cart_div,
                    'total_price' => $total_price
                ]);
            }
        
    }

    public function delete(Request $request){
    
        $cart = Cart::find($request->cart_id);
        $cartDelete = $cart->delete();
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
        if($cart_data->count() == 0){
            return response()->json([
                'cart_empty' => 'Cart empty'
            ]);
        }
        $cart_total = 0;
        foreach($cart_data as $cart){
            $cart_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
            $cart_total += $cart_total_price;
        }
        if($cartDelete){
            return response()->json([
                'success' => 'Cart Item Removed',
                'cart_total' => $cart_total
            ]);
        }else{
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }

    public function decrement(Request $request){
       $cart = Cart::find($request->cart_id);
        $cart_update = $cart->update([
            'qty' => $request->qty
        ]);
       
        $qty = $cart->qty;
        $subtotal = $cart->qty*$cart->relCartToProduct->selling_price;
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
        $cart_total = 0;
        $cart_item_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
        foreach($cart_data as $cart){
            $cart_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
            $cart_total += $cart_total_price;
        }
        if($cart_update){
            return response()->json([
                'updated' => 'Upated',
                'cart_item_total_price' => $cart_item_total_price,
                'cart_total' => $cart_total,
                'qty' => $qty,
                'subtotal' => $subtotal
            ]);
        }else{
            return response()->json([
                'error' => 'Not Upated'
            ]);
        }
    }

    public function increment(Request $request){
        $cart = Cart::find($request->cart_id);
         $cart_update = $cart->update([
             'qty' => $request->qty
         ]);
         $qty = $cart->qty;
         $subtotal = $cart->qty*$cart->relCartToProduct->selling_price;
         $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
        $cart_total = 0;
        $cart_item_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
        foreach($cart_data as $cart){
            $cart_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
            $cart_total += $cart_total_price;
        }
         if($cart_update){
             return response()->json([
                 'updated' => 'Upated',
                 'cart_item_total_price' => $cart_item_total_price,
                 'cart_total' => $cart_total,
                 'qty' => $qty,
                 'subtotal' => $subtotal
             ]);
         }else{
             return response()->json([
                 'error' => 'Not Upated'
             ]);
         }
    }

    public function applyCoupon(Request $request){
        $request->validate([
            'coupon_code' => 'required'
        ]);

        $exitCoupon = Coupon::where('coupon_name', $request->coupon_code)->first();
        if($exitCoupon != null){
            $cart_total = 0;
            $cid = session('LoggedCustomer');
            $customer = Customer::where('customer_email', $cid)->first();
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            foreach($cart_data as $cart){
                $cart_total_price = $cart->qty*$cart->relCartToProduct->selling_price;
                $cart_total += $cart_total_price;
            }
           $after_coupon =  ($cart_total*$exitCoupon->coupon_value) / 100;
           return back()->with('total_price_after_coupon',$after_coupon);
        }else{
            return back()->with('coupon_not_exist','Invalid Code');
        }

    }
    
}
