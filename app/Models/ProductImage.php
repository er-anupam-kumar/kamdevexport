<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    public function getParentProduct()
    {
        return $this->belongsTo(Product::Class,'product_id','id');
    }
}
