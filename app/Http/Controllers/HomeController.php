<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function index(Request $request){
        $categories=Category::all();
        $query=Products::query();
        if($request->filled("category_id"))
            $query->where("category_id",$request->category_id);
        $products= $query->orderBy("id","DESC")->paginate(9);
        return view('index')
        ->with("categories",$categories)
        ->with("products",$products)
        ;
    }
}
