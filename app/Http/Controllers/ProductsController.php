<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use App\Http\Controllers\Controller;
use App\Models\Category;

class ProductsController extends Controller
{
    public function index(Request $request){
        $query=Products::query();
        if($request->filled('search'))
            $query->where("name","LIKE","%{$request->search}%");
        if($request->filled("category_id"))
            $query->where("category_id",$request->category_id);
        $products= $query->with(['category'])->orderBy("id","DESC")->paginate(15);

        $categories=Category::orderBy("id","DESC")->get();
        return view("products")
        ->with("products",$products)
        ->with("categories",$categories)
        ->with("search",$request->search)
        
        ;
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required",
            "image"=>"required",
            "volume"=>"required",
            "dimensions"=>"required",
            "weight"=>"required",
            "features"=>"required",
            "price"=>"required",
            "category_id"=>"required",
        ]);
        $product=Products::create([
            "name"=>$request->name,

            "weight"=>$request->weight,
            "dimensions"=>$request->dimensions,
            "volume"=>$request->volume,
            "price"=>$request->price,
            "category_id"=>$request->category_id,
            'image'=>Helpers::upload_files($request->image),
            "features"=>$request->features,
        ]);
        session()->flash("success","Added Successfully");
        return back();
    }
    public function update(Request $request){
        $request->validate([
            "name"=>"required",
            "volume"=>"required",
            "dimensions"=>"required",
            "weight"=>"required",
            "price"=>"required",
            "category_id"=>"required",
            "product_id"=>"required",
        ]);
        $product=Products::find($request->product_id);
        if(! $product)
            return back();
        if($request->hasFile('image')){
            Helpers::delete_file($product->image);
            $product->update([
                "image"=>Helpers::upload_files($request->image),
            ]);
        }
        $product->update([
            "name"=>$request->name,
            "weight"=>$request->weight,
            "dimensions"=>$request->dimensions,
            "volume"=>$request->volume,
            "price"=>$request->price,
            "category_id"=>$request->category_id,
            "features"=>$request->features,

        ]);

        session()->flash("success","Updated Successfully");
        return back();
    }
    public function destroy(Request $request){
        $request->validate([
            "product_id"=>"required"
        ]);
        $product=Products::find($request->product_id);
        if(! $product)
            return back();
        Helpers::delete_file($product->image);

        $product->delete();
        session()->flash("success","Deleted Successfully");
        return back();
    }

}
