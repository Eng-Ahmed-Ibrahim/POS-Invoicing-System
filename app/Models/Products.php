<?php

namespace App\Models;

use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    use HasFactory;
    protected $table="products";
    protected $guarded=[];
    public function category()
    {
        return $this->belongsTo(Category::class,"category_id");
    }

}
