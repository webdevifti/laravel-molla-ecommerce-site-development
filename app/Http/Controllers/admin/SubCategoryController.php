<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    //
    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $getCategories = Category::withoutTrashed()->get();
        $getSubCategories = SubCategory::all();
        return view('admin.subcategory.index',compact('trashedItemCounnt','getCategories','getSubCategories'));
    }

    public function store(Request $request){
        
        $request->validate([
            'category_id' => 'required',
            'sub_category_name' => 'required|string|max:255'
        ],[
            'category_id.required' => 'Please select a category name',
            'sub_category_name.required' => 'Please provide a subcategory name'
        ]);

        if(SubCategory::where('category_id', $request->category_id)->where('sub_category_name', $request->sub_category_name)->exists()){
            return back()->with('error','This sub category already exist in selected category');
        }else{

            try{
                SubCategory::create([
                    'category_id' => $request->category_id,
                    'sub_category_name' => $request->sub_category_name,
                    'user_id' => Auth::id()
                ]);
                return back()->with('success','Sub Category has been added successfully.');
            }catch(Exception $e){
                return back()->with('error','Something went wrong!');
            }
        }
    }

    public function edit($id){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $getCategories = Category::withoutTrashed()->get();
        $sub_category = SubCategory::find($id);
        return view('admin.subcategory.edit', compact('sub_category','trashedItemCounnt','getCategories'));
    }
    public function update(Request $request,$id){
        $sub_cat = SubCategory::find($id);
        try{
            $sub_cat->category_id = $request->category_id;
            $sub_cat->sub_category_name = $request->sub_category_name;
            $sub_cat->save();
            return back()->with('success','Sub category has been updated');
        }catch(Exception $e){
            return back()->with('error','Something went wrong!');
        }
    }
    public function delete($id){
        try{
            SubCategory::find($id)->delete();
            return back()->with('success', 'Sub Category has been deleted');
        }catch(Exception $e){
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function changeStatus($id){
        $subcategory = SubCategory::select('status')->where('id','=',$id)->first();

        if($subcategory->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        SubCategory::where('id',$id)->update($values);
        return back()->with('success',"Status Changed");
    }
}
