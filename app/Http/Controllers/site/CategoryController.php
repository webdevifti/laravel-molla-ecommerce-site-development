<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    // public function index($slug){
    //     $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
    //     // $fetch_category = Category::where('category_slug',$slug)->withoutTrashed()->get();
    //     return view('category',compact('fetch_category','get_all_cats'));
    // }

    public function getCategoryProduct($category_slug){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
       
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->get();
        }else{
            $cart_data = [];
        }
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $cat = Category::where('category_slug', $category_slug)->first();
        $category = $cat->category_name;
        $get_category_product = Product::where('category_id',$cat->id)->paginate(20);
      
        return view('category', compact('customer','category','cart_data','get_all_cats','get_category_product'));
    }
}
