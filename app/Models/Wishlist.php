<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','customer_id'];

    public function rel_wishToProduct(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
