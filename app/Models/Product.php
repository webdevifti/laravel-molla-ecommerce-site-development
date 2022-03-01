<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'sub_category',
        'product_title',
        'product_slug',
        'product_sku',
        'discount',
        'regular_price',
        'selling_price',
        'product_preview_img',
        'description',
        'addition_information',
        'shipping_and_return_condition',
        'quantity',
        'status',
        'added_by'
    ];

    public function relUserToProduct(){
        return $this->belongsTo(User::class, 'added_by');
    }

    public function relCatToProduct(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function relSubCatToProduct(){
        return $this->belongsTo(SubCategory::class, 'sub_category');
    }


}
