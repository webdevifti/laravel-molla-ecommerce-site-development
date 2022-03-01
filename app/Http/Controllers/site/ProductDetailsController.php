<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{
    //
    public function index($pid){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
        }else{
            $cart_data = [];
        }
        $product_info = Product::where('product_slug',$pid)->first();
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $related_product = Product::where('category_id', $product_info->category_id)->where('product_slug','!=',$pid)->get();
        $also_like = Product::where('product_slug','!=',$pid)->inRandomOrder()->take(10)->get();
        return view('single-product', compact('customer','cart_data','product_info','get_all_cats','related_product','also_like'));
    }

}
