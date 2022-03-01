<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    //
    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $get_categories = Category::orderBy('created_at','desc')->get();
        return view('admin.category.index', compact('get_categories','trashedItemCounnt'));
    }

    public function create(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        return view('admin.category.create', compact('trashedItemCounnt'));
    }
    public function store(CategoryRequest $request){
        try{

            $slug = trim(strtolower(str_replace(' ','-',$request->category_name)));
            $category_id = Category::insertGetId([
                'category_name' => $request->category_name,
                'category_slug' => $slug,
                'added_by' => Auth::id(),
                'created_at' => Carbon::now()
            ]);
    
            if($request->category_image){
                $image = $request->category_image;
                $extension = $image->getClientOriginalExtension();
                $imageName = $category_id.'.'.$extension;
                $request->category_image->move(public_path('uploads/categories/'), $imageName);
    
                Category::find($category_id)->update([
                    'category_image' => $imageName,
                ]);
            }
            return back()->with('success','Category has been added successfully');
        }catch(Exception $e){
            return back()->with('error','Something Happened wrong!');

        }
    }

    public function BulkOpration(Request $request){
        // check bulk submit button is clicked
        if($request->bulkSubmit == 'bulk_submit'){
            $request->validate([
                'bulk_options' => 'required',
                'mark' => 'required',
            ],[
                'bulk_options.required' => 'Please Select An Option',
                'mark.required' => 'You Must Be Select An Item',
            ]);

            if($request->bulk_options == 'trash'){
                foreach($request->mark as $m){
                    $cats = Category::whereIn('id',$request->mark)->delete();
                    return back()->with('success','Category moved to the trash file.');
                }
            }else if($request->bulk_options == 'active'){
                foreach($request->mark as $m){
                    Category::whereIn('id',$request->mark)->update([
                        'status' => 1,
                    ]);
                }
                return back()->with('success','Status Activated');
            }else if($request->bulk_options == 'inactive'){
                foreach($request->mark as $m){
                    Category::whereIn('id',$request->mark)->update([
                        'status' => 0,
                    ]);
                }
                return back()->with('success','Status Inactivated');
            }else if($request->bulk_options == 'restore'){
                foreach($request->mark as $m){
                    Category::whereIn('id',$request->mark)->onlyTrashed()->restore();
                    return back()->with('success','Category restored. Go to categories page');
                }
            }else if($request->bulk_options == 'permanentDelete'){
                foreach($request->mark as $m){
                    // dd($cats);
                    Category::whereIn('id',$request->mark)->onlyTrashed()->forceDelete();
                    
                    // $cats = Category::whereIn('id',$request->mark)->onlyTrashed()->get();
                    // unlink(public_path('uploads/categories/'.$cats->category_image));
                    return back()->with('success','Category has been permanently deleted');
                }
            }
        }
    }
    public function edit($id){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $category = Category::find($id);
        return view('admin.category.edit', compact('category','trashedItemCounnt'));
    }
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'category_name' => 'required|string|max:255',
           
        ]);
        if($request->category_image){
            $request->validate([
                'category_image' => 'mimes:jpg,png,jpeg'
            ]);
           
            $category = Category::findOrfail($id);
            $extension = $request->category_image->getClientOriginalExtension();
            $imageName = $category->id.'.'.$extension;

            unlink(public_path('uploads/categories/'.$category->category_image));
            $request->category_image->move(public_path('uploads/categories/'), $imageName);
            $slug = trim(strtolower(str_replace(' ','-',$request->category_name)));
            try{
                $category->category_name = $request->category_name;
                $category->category_slug = $slug;
                $category->category_image = $imageName;
                $category->save();
          
                return back()->with('success','Category Updated Sucessfully!');
            }catch(Exception $e){
                return back()->with('error','Could not Updated!');
            }
        }else{
            try{
                $slug = trim(strtolower(str_replace(' ','-',$request->category_name)));
                $cat = Category::findOrfail($id);
                $cat->category_name = $request->category_name;
                $cat->category_slug = $slug;
                $cat->save();
          
                return back()->with('success','Category Updated Sucessfully!');
            }catch(Exception $e){
                return back()->with('error','Could not Updated!');
            }
        }
    }

    public function changeStatus($id){
        $category = Category::select('status')->where('id','=',$id)->first();

        if($category->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Category::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
    }

    public function trash($id){
        Category::find($id)->delete();
        return back()->with('success','Category moved to the trash file');
    }

    public function restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return back()->with('success', "Category restored. Go to categories page");
    }
    public function trashList(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $trash_category = Category::onlyTrashed()->get();
        return view('admin.category.trash',compact('trash_category','trashedItemCounnt'));
    }

    public function permanentlyDelete($id){
        $cats_id = Category::onlyTrashed()->find($id);
         Category::onlyTrashed()->find($id)->forceDelete();
        //  $subcat = SubCategory::where('category_id', $id)->first();
        //  $subcat->delete();
        unlink(public_path('uploads/categories/'.$cats_id->category_image));
        return back()->with('success', "Category has been permanently deleted");
    }
}
