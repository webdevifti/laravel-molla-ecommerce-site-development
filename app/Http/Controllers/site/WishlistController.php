<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //
    public function index(){
        $get_all_cats = Category::where('status',1)->withoutTrashed()->get();
        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        // dd($customer);
        if($customer != null){
            $cart_data = Cart::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
            $wishlist_data = Wishlist::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();

        }else{
            $cart_data = [];
            $wishlist_data = [];
        }
       
        return view('wishlist', compact('customer','get_all_cats','cart_data','wishlist_data'));
    }
    public function create(Request $request){
        if(session('LoggedCustomer')){
            $customer = Customer::where('customer_email',session('LoggedCustomer'))->first();
            $check_exist = Wishlist::where('product_id', $request->pid)->where('customer_id',$customer->id)->first();
            if($check_exist != null){
                return response()->json([
                    'already_exist' => 'This Product already exist in your wishlist',
                ]);
            }else{

                $customer = Customer::where('customer_email',session('LoggedCustomer'))->first();
                $wishlist = Wishlist::create([
                    'product_id' => $request->pid,
                    'customer_id' => $customer->id
                ]);
                if($wishlist){
                    return response()->json([
                        'wishlist_added_success' => 'Added to your wishlist',
                        
                    ]);
                }else{
                     return response()->json([
                        'wishlist_added_error' => 'Error occured',
                    ]);
                }
            }

        }else{
            return response()->json([
                'error_message' => 'login_required'
            ]);
        }
    }

    public function delete(Request $request){
        $wishlist = Wishlist::find($request->wishlist_id);
        $d = $wishlist->delete();

        $cid = session('LoggedCustomer');
        $customer = Customer::where('customer_email', $cid)->first();
        $wishlist_data = Wishlist::where('customer_id',$customer->id)->orderBy('created_at','DESC')->get();
        if($wishlist_data->count() == 0){
            return response()->json([
                'empty_wishlist' => 'wishlist empty',
                
            ]);
        }
        if($d){
            return response()->json([
                'success' => 'Removed from wishlist',
                
            ]);
        }else{
            return response()->json([
                'error' => 'Something went wrong'
            ]);
        }
    }
}
