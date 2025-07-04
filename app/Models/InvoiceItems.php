<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;
    protected $table="invoice_items";
    protected $guarded=[];
    public function invoice()
    {
        return $this->belongsTo(Invoices::class,"invoice_id");
    }
}
