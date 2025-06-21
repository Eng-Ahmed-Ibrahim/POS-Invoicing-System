<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index(Request $request){
        $query=Clients::query();
        if($request->filled("search"))  
            $query->where("name","like","%{$request->search}%")
                ->orWhere("phone","like","%{$request->search}%")
                ->orWhere("email","like","%{$request->search}%");
        $clients= $query->orderBy("id","DESC")->paginate(15);
        return view("clients")
        ->with("clients",$clients)
        ;
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required",
            // "email" => "required|unique:clients,email",
            "phone" => "required|unique:clients,phone",

        ]);
        Clients::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "address"=>$request->address,
        ]);
        session()->flash("success","Added Successfully");
        return back();
    }
    public function update(Request $request){
        $request->validate([
            "client_id"=>"required",
            "name"=>"required",
            "email" => "nullable",
            "phone" => "nullable",

        ]);
        $client=Clients::find($request->client_id);
        if(!$client)
            return back();
        $client->update([
            "name"=>$request->name ?? $client->name,
            "email"=>$request->email ?? $client->email,
            "phone"=>$request->phone ?? $client->phone,
            "address"=>$request->address ?? $client->address,
        ]);
        session()->flash("success","Updated Successfully");
        return back();
    }
    public function destroy(Request $request){
        $request->validate([
            "client_id"=>"required",
        ]);
        $client=Clients::find($request->client_id);
        if(!$client)
            return back();
        $client->delete();
        session()->flash("success","Deleted Successfully");
        return back();
    }
}
