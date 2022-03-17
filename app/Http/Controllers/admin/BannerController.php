<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $banners = Banner::orderBy('created_at', 'DESC')->get(); 
        return view('admin.banner.index', compact('banners','trashedItemCounnt'));
    }

    public function create(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        return view('admin.banner.create', compact('trashedItemCounnt'));
    }
    public function store(Request $request){
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_regular_price' => 'required',
            'product_selling_price' => 'required',
            'banner_product_image' => 'required'
        ]);
        try{

            $add_banner = Banner::insertGetId([
                'product_name' => $request->product_name,
                'special_notes' => $request->notes,
                'regular_price' => $request->product_regular_price,
                'selling_price' => $request->product_selling_price,
                'created_at' => Carbon::now()
            ]);
   
            if($request->banner_product_image){
                $image = $request->banner_product_image;
                $extension = $image->getClientOriginalExtension();
                $imageName = $add_banner.'.'.$extension;
                $request->banner_product_image->move(public_path('uploads/banners/'), $imageName);
        
                Banner::find($add_banner)->update([
                    'product_image' => $imageName,
                ]);
            }
            return back()->with('success', 'Banner Item added');
        }catch(Exception $e){

            return back()->with('error', 'Something wrong');
        }
    }

    public function changeStatus($id){
        $banner = Banner::select('status')->where('id','=',$id)->first();

        if($banner->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Banner::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
    }
    public function BulkOpration(Request $request){
        if($request->bulkSubmit == 'bulk_submit'){
            $request->validate([
                'bulk_options' => 'required',
                'mark' => 'required',
            ],[
                'bulk_options.required' => 'Please Select An Option',
                'mark.required' => 'You Must Be Select An Item',
            ]);

           if($request->bulk_options == 'active'){
                foreach($request->mark as $m){
                    Banner::whereIn('id',$request->mark)->update([
                        'status' => 1,
                    ]);
                }
                return back()->with('success','Status Activated');
            }else if($request->bulk_options == 'inactive'){
                foreach($request->mark as $m){
                    Banner::whereIn('id',$request->mark)->update([
                        'status' => 0,
                    ]);
                }
                return back()->with('success','Status Inactivated');
            }
        }
    }


    public function delete($id){
        $banner = Banner::find($id)->delete();
        unlink(public_path('uploads/banners/'.$banner->product_image));
        return back()->with('success', "Banner has been permanently deleted");
    }
}
