<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;
    protected $table="invoices";
    protected $guarded=[];
    public function items()
    {
        return $this->hasMany(InvoiceItems::class, 'invoice_id');
    }
    public function client()
    {
        return $this->belongsTo(Clients::class,"client_id");
    }
}
