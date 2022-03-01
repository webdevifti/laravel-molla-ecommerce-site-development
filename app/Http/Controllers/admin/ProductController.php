<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //

    public function index(){
        $get_products = Product::orderBy('created_at','DESC')->get();
        $trashedItemCounnt = Category::onlyTrashed()->count();
        return view('admin.product.index', compact('get_products','trashedItemCounnt'));
    }

    public function create(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $get_cats = Category::where('status',1)->withoutTrashed()->get();
        return view('admin.product.create', compact('trashedItemCounnt','get_cats'));
    }

    public function store(ProductRequest $request){
        // $slug = Str::slug($request->product_title);
            $slug = trim(strtolower(str_replace(' ','-', $request->product_title)));
            $discount_price = $request->price - $request->price*$request->discount/100;
            $sku = rand(111111111,999999999);
            try{
                $last_pid = Product::insertGetId([
                    'category_id' => $request->product_category,
                    'sub_category' => $request->product_subcategory,
                    'discount' => $request->discount,
                    'regular_price' => $request->price,
                    'selling_price' => $discount_price,
                    'product_title' => $request->product_title,   
                    'product_slug' => $slug,
                    'quantity' => $request->quantity,
                    'product_sku' => $sku,
                    'description' => $request->description,
                    'addition_information' => $request->additional_info,
                    'shipping_and_return_condition' => $request->shipping_and_return_condition,
                    'added_by' => Auth::id(),
                    'created_at' => Carbon::now()
                ]);
                if($request->product_preview_image){
                    $image = $request->product_preview_image;
                    $extension = $image->getClientOriginalExtension();
                    $imageName = 'product'.$last_pid.'.'.$extension;
                    $request->product_preview_image->move(public_path('uploads/products/previews/'), $imageName);
        
                    Product::find($last_pid)->update([
                        'product_preview_img' => $imageName,
                    ]);
                }
                return back()->with('success','Product has been added successfully');
            }catch(Exception $e){
                return back()->with('error','Something went wrong');
            }
        

        
    }
    public function getCategory(Request $request){
        $output = '<option value="">--Select Product Sub Category--</option>';
        foreach(SubCategory::where('category_id',$request->category_id)->get() as $subcat){
            $output .= '<option value="'.$subcat->id.'">'.$subcat->sub_category_name.'</option>';
        }
        echo $output;
    }

    public function changeStatus($id){
        $product = Product::select('status')->where('id','=',$id)->first();

        if($product->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Product::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
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

            if($request->bulk_options == 'active'){
                foreach($request->mark as $m){
                    Product::whereIn('id',$request->mark)->update([
                        'status' => 1,
                    ]);
                }
                return back()->with('success','Status Activated');
            }else if($request->bulk_options == 'inactive'){
                foreach($request->mark as $m){
                    Product::whereIn('id',$request->mark)->update([
                        'status' => 0,
                    ]);
                }
                return back()->with('success','Status Inactivated');
            }
        }
    }
    public function edit($id){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $get_cats = Category::where('status',1)->withoutTrashed()->get();
        $get_subcats = SubCategory::where('status',1)->get();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product','trashedItemCounnt','get_cats','get_subcats'));
    }

    public function update($id){

    }

    public function delete($id){
        $pid = Product::find($id);
        $pid->delete();
       unlink(public_path('uploads/products/previews/'.$pid->product_preview_img));
       return back()->with('success', "Product has been permanently deleted");
    }
}
