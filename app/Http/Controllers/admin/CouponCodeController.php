<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class CouponCodeController extends Controller
{
    //
    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $coupons = Coupon::all();
        return view('admin.coupon.index', compact('coupons','trashedItemCounnt'));
    }

    public function store(Request $request){
        $request->validate([
            'coupon_name' => 'required',
            'coupon_value' => 'required',
            'coupon_expire' => 'required'
        ]);

        try{
            Coupon::create([
                'coupon_name' => $request->coupon_name,	
                'coupon_value' => $request->coupon_value,
                'coupon_expire' => $request->coupon_expire
            ]);

            return back()->with('success', 'Coupon Code Created successfully');
        }catch(Exception $e){
            return back()->with('error', 'Something happened wrong');

        }

    }
    public function statusChange($id){
        $coupon = Coupon::select('status')->where('id','=',$id)->first();

        if($coupon->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Coupon::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
    }
    public function delete($id){
        try{
            Coupon::findOrFail($id)->delete();
            return back()->with('success', 'Coupon Deleted');
        }catch(Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }
}
