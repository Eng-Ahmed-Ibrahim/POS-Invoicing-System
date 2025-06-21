<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request){
        $query=Category::query();
        if($request->filled("search"))
            $query->where("name","LIKE","%{$request->search}%");
        $categories=$query->orderBy("id","DESC")->get();
        return view("categories")
        ->with("categories",$categories)
        
        ;
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required",
        ]);
        Category::create([
            "name"=>$request->name,
        ]);
        session()->flash("success","Added Successfully");
        return back();
    }
    public function update(Request $request){
        $request->validate([
            "name"=>"required",
            "category_id"=>"required"
        ]);
        $category=Category::find($request->category_id);
        if(! $category)
            return back();

        $category->update([
            "name"=>$request->name,
        ]);
        session()->flash("success","Updated Successfully");
        return back();
    }
    public function destroy(Request $request){
        $request->validate([
            "category_id"=>"required"
        ]);
        $category=Category::find($request->category_id);
        if(! $category)
            return back();
        Helpers::delete_file($category->image);

        $category->delete();
        session()->flash("success","Deleted Successfully");
        return back();
    }



}
