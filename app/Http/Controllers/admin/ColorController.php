<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use Exception;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    //

    public function index(){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $colors = Color::all();
        return view('admin.color.index',compact('colors','trashedItemCounnt'));
    }

    public function store(Request $request){
        $request->validate([
            'color_name' => 'required|string|max:255'
        ]);

        try{
            Color::create([
                'color_name' => $request->color_name,
            ]);
            return back()->with('success', 'Color added');
        }catch(Exception $e){
            return back()->with('error', 'Something went wrong');
        }
       
    }
    public function changeStatus($id){
        $color = Color::select('status')->where('id','=',$id)->first();

        if($color->status == 1){
            $status = '0';
           
        }else{
            $status = '1';
        }
        $values = array('status' => $status);
        Color::where('id',$id)->update($values);

        return back()->with('success',"Status Changed");
    }

    public function edit($id){
        $trashedItemCounnt = Category::onlyTrashed()->count();
        $color = Color::findOrFail($id);
        return view('admin.color.edit', compact('color','trashedItemCounnt'));
    }

    public function update(Request $request, $id){
        try{
            $color = Color::findOrFail($id);
            $color->color_name = $request->color_name;
            $color->save();
            return back()->with('success', 'Color Updated');
        }catch(Exception $e){
            return back()->with('error', 'Something went wrong');
        }

    }
    public function delete($id){
        try{
            Color::findOrFail($id)->delete();
            return back()->with('success', 'Color Deleted');
        }catch(Exception $e){
            return back()->with('error', 'Something went wrong');
        }
    }
}
