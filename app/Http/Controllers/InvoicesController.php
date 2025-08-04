<?php

namespace App\Http\Controllers;

use App\CPU\Helpers;
use App\Models\User;
use App\Models\Clients;
use App\Models\Invoices;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Services;
use App\Models\InvoiceItems;
use Illuminate\Http\Request;
use Faker\Provider\ar_EG\Payment;
use App\Http\Controllers\Controller;
use App\Notifications\PushNotification;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        $is_invoice=true;
        $query = Invoices::query();
        if($request->filled('quotation')){
            $query->where("is_invoice",false)->orWhere("status",6);//status = 6 => Converted to Invoice
            $is_invoice=false;
        }else{
            $query->where("is_invoice",true);
        }
        if ($request->filled("search"))
            $query->where("id", $request->search);
        $invoices = $query->orderBy("id", "DESC")
            ->with(['items'])
            ->paginate(15);
            
        $clients = Clients::orderBy("id", "DESC")->get();
        $products = Products::orderBy("id", "DESC")->get();
        
        return view('invoices.index')
            ->with("invoices", $invoices)
            ->with("clients", $clients)
            ->with("is_invoice", $is_invoice)
            ->with("products", $products)
        ;
    }
    public function view($invoice_id)
    {
        $products = Products::orderBy("id", "DESC")->get();
        $invoice = Invoices::where("id", $invoice_id)->with(["items", 'client'])->first();
        return view('invoices.view')
            ->with("invoice", $invoice)
            ->with("products", $products)

            ;
    }
    public function add_invoice(Request $request)
    {
        $request->validate([
            "client_id" => "required",
            "product_id" => "required",
            "quantity" => "required",
            "is_invoice" => "required|in:1,0",
            "without_vat" => "required",
        ]);
        $product = Products::find($request->product_id);
        $invoice = Invoices::create([
            "client_id" => $request->client_id,
            "date" => $request->date,
            "is_invoice"=>$request->is_invoice,
            "status"=>$request->is_invoice  ? 0 : 3,
        ]);
        $total = $request->with_vat > 0 ? $request->with_vat * $request->quantity : $request->without_vat * $request->quantity;
        InvoiceItems::create([
            "invoice_id" => $invoice->id,
            "model_number" => $product->name,
            "volume" => $product->volume,
            "dimensions" => $product->dimensions,
            "weight" => $product->weight,
            "without_vat" => $request->without_vat,
            "with_vat" => $request->with_vat,
            "quantity" => $request->quantity,
            "total" => $total,
            "image" => $product->image,
            "features"=>$product->features,

        ]);
        session()->flash("success", "Invoice Created Successfully");
        return back();
    }
    public function add_item(Request $request)
    {
        $request->validate([
            "invoice_id" => "required",
            "product_id" => "required",
            "quantity" => "required",
            "without_vat" => "required",
        ]);
        $product = Products::find($request->product_id);
        $invoice = Invoices::find($request->invoice_id);
        $total = $request->with_vat > 0 ? $request->with_vat * $request->quantity : $request->without_vat * $request->quantity;
        InvoiceItems::create([
            "invoice_id" => $invoice->id,
            "model_number" => $product->name,
            "volume" => $product->volume,
            "dimensions" => $product->dimensions,
            "weight" => $product->weight,
            "without_vat" => $request->without_vat,
            "with_vat" => $request->with_vat,
            "quantity" => $request->quantity,
            "total" => $total,
            "image" => $product->image,
            "features"=>$product->features,

        ]);
        session()->flash("success", "Item Added");
        return back();
    }
    public function delete_item($item_id){
        $item=InvoiceItems::find($item_id);
        if(! $item)
            return back();
        $item->delete();
        session()->flash("success", "Item Deleted Successfully");

        return back();
    }
    public function delete($invoice_id)
    {
        $invoice = Invoices::find($invoice_id);
        if (! $invoice)
            return back();
        $invoice->delete();
        session()->flash("success", "Invoice Deleted Successfully");
        return back();
    }

    public function update_status($invoice_id, $status)
{
    // Find the invoice by ID
    $invoice = Invoices::findOrFail($invoice_id);

    // Update the status
    $invoice->status = $status;
    if($status==6)
        $invoice->is_invoice=1;
    $invoice->save();

    // Redirect or return response
    return redirect()->back()->with('success', 'Invoice status updated successfully.');
}




    public function generate_pdf($invoice_id)
    {

        $invoice = Invoices::where("id", $invoice_id)->with(["items", 'client'])->first();
        $pdf = Pdf::loadView('invoices.template', ["invoice" => $invoice]); // `pdf.example` refers to the Blade view file
        $pdf_name = $invoice->is_invoice ? " #INV-$invoice->id.pdf" :" #QTN-$invoice->id.pdf";
        return $pdf->download($pdf_name ); // Download the PDF file
    }


    public function change_status(Request $request)
    {
        $request->validate([
            "invoice_id" => "required",
            "status" => "required",
        ]);
        $invoice = Invoices::find($request->invoice_id);
        if (!$invoice) {
            session()->flash('message', "Not Found");
            session()->flash('type', 'error');
            return  back();
        }
        $invoice->update([
            "status" => $request->status,
            "updated_at" => now(),

        ]);
        session()->flash('message', "Changed Successfully");
        session()->flash('type', 'success');
        return  back();
    }
}
