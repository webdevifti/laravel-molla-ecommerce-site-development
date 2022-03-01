<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
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
        $explore_popular_categories = Category::where('status',1)->withoutTrashed()->limit(6)->get();
        $all_brands = Brand::where('status',1)->get();
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $new_arrivals_products = Product::where('status',1)->orderBy('created_at', 'DESC')->limit(20)->get();
        $all_products = Product::where('status',1)->get();
        $recomanded_products = Product::where('status',1)->orderBy('created_at','DESC')->limit(8)->get();
        return view('index', compact('recomanded_products','all_products','cart_data','explore_popular_categories','get_all_cats','all_brands','new_arrivals_products','customer'));
    }

    public function search(){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            
        }else{
            $cart_data = [];
        }
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $q = request()->query('q');

        $get_search_product = Product::where('product_title','like','%'.$q.'%')->orWhere('category_id','like','%'.$q.'%')->paginate(20);
        // dd($get_search_product);
        return view('search', compact('get_all_cats','cart_data','q','get_search_product','customer'));
    }


    public function shop(){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            
        }else{
            $cart_data = [];
        }
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();

        $all_products = Product::where('status',1)->get();
        return view('shop', compact('customer','cart_data','get_all_cats','all_products'));
    }
}
