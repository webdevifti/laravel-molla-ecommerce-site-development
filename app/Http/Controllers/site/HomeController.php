<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Banner;
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
        $banner_sliders = Banner::where('status',1)->get();
        return view('index', compact('banner_sliders','recomanded_products','all_products','cart_data','explore_popular_categories','get_all_cats','all_brands','new_arrivals_products','customer'));
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


    public function shop(Request $request){
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            
        }else{
            $cart_data = [];
        }
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();

        $sort = '';
        $sort_text = '';
        if($request->get('sort') !== null){
            $sort = $request->get('sort');
            
            if($sort == 'default'){
                $sort_text = 'Sort by default';
                $all_products = Product::where('status',1)->get();
            }else if($sort == 'rating'){
                $sort_text = 'Sort by Rating';
                $all_products = Product::where('status',1)->get();
            }else if($sort == 'date_asc'){
                $sort_text = 'Sort by date newest';
                $all_products = Product::where('status',1)->orderBy('created_at','ASC')->get();
            }else if($sort == 'date_desc'){
                $sort_text = 'Sort by date oldest';
                $all_products = Product::where('status',1)->orderBy('created_at','DESC')->get();
            }else if($sort == 'price_low_to_high'){
                $sort_text = 'Sort by price low to high';
                $all_products = Product::where('status',1)->orderBy('selling_price','ASC')->get();
            }else if($sort == 'price_high_to_low'){
                $sort_text = 'Sort by price high to low';
                $all_products = Product::where('status',1)->orderBy('selling_price','DESC')->get();
            }
        }else{
            $all_products = Product::where('status',1)->paginate(6);

            if ($request->ajax()) {
                $html = '';
    
                foreach ($all_products as $item) {
                    $html.=' <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                    <div class="product">
                        <figure class="product-media">
                            <a href="'.route('product.detail', $item->product_slug).'">
                                <img src="'.asset('uploads/products/previews/'.$item->product_preview_img).'" alt="Product image" class="product-image">
                            </a>

                            <div class="product-action-vertical">
                                <a href="javascript:void(0)" onclick="addtowishlist('.$item->id.')" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                            </div>

                            <div class="product-action action-icon-top">'.if($item->quantity < 1){.'<span style="color: red">Out of stock</span>'.}else{.'
                                <button onclick="addtocart('.$item->id.','.(session('LoggedCustomer')) ? $customer->id : ''.')" class="btn-product btn-cart"><span>add to cart</span></button>
                                '.}'
                               
                            </div>
                        </figure>

                        <div class="product-body">
                            <div class="product-cat">
                                <a href="/shop/'.$item->relCatToProduct->category_slug.'">'.$item->relCatToProduct->category_name.'</a>
                            </div>
                            <h3 class="product-title"><a href="'.route('product.detail', $item->product_slug).'">'.$item->product_title .'</a></h3>
                            <div class="product-price">
                                BDT: '.$item->selling_price.'
                            </div>
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 0%;"></div>
                                </div>
                                <span class="ratings-text">( 0 Reviews )</span>
                            </div>
                        </div>
                    </div>
                </div>';
                }
    
                return $html;
            }
        }
       
        // 
        return view('shop', compact('sort_text','customer','cart_data','get_all_cats','all_products'));
    }
}
