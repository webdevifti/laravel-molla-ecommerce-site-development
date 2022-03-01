<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    //

    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $brands = Brand::orderBy('created_at','DESC')->get();
        return view('admin.brand.index',compact('brands','trashedItemCounnt'));
    }

    public function store(Request $request){
        $request->validate([
            'brand_name' => 'required|string|max:255|unique:brands',
            'brand_image' => 'required|mimes:jpg,png,jpeg|max:2048'
        ]);
        try{
            $slug = trim(strtolower(str_replace(' ','-',$request->brand_name)));
            $brand_id = Brand::insertGetId([
                'brand_name' => $request->brand_name,
                'brand_slug' => $slug, 
                'added_by' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
        
            if($request->brand_image){
                $image = $request->brand_image;
                $extension = $image->getClientOriginalExtension();
                $imageName = $brand_id.'.'.$extension;
                $request->brand_image->move(public_path('uploads/brands/'), $imageName);
    
                Brand::find($brand_id)->update([
                    'brand_image' => $imageName,
                ]);
            }
            return back()->with('success','Brand has been added successfully');
        }catch(Exception $e){
            return back()->with('error','Something Happened wrong!');
        }
    }
    public function edit($id){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand','trashedItemCounnt'));
    }
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'brand_name' => 'required|string|max:255',
           
        ]);
        if($request->brand_image){
            $request->validate([
                'brand_image' => 'mimes:jpg,png,jpeg'
            ]);
           
            $brand = Brand::findOrfail($id);
            $extension = $request->brand_image->getClientOriginalExtension();
            $imageName = $brand->id.'.'.$extension;

            unlink(public_path('uploads/brands/'.$brand->brand_image));
            $request->brand_image->move(public_path('uploads/brands/'), $imageName);
            $slug = trim(strtolower(str_replace(' ','-',$request->brand_name)));
            try{
                $brand->brand_name = $request->brand_name;
                $brand->brand_slug = $slug;
                $brand->brand_image = $imageName;
                $brand->save();
          
                return back()->with('success','Brand Updated Sucessfully!');
            }catch(Exception $e){
                return back()->with('error','Could not Updated!');
            }
        }else{
            try{
                $slug = trim(strtolower(str_replace(' ','-',$request->brand_name)));
                $cat = Brand::findOrfail($id);
                $cat->brand_name = $request->brand_name;
                $cat->brand_slug = $slug;
                $cat->save();
          
                return back()->with('success','Brand Updated Sucessfully!');
            }catch(Exception $e){
                return back()->with('error','Could not Updated!');
            }
        }
    }

    public function changeStatus($id){
        $brand = Brand::select('status')->where('id','=',$id)->first();

        if($brand->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Brand::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
    }

    public function delete($id){
        $brand_id = Brand::find($id);
        $brand_id->delete();
        unlink(public_path('uploads/brands/'.$brand_id->brand_image));
        return back()->with('success', "Brand has been permanently deleted");
    }
}
