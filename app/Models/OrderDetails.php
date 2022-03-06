<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rel_to_order_purchase(){
        return $this->belongsTo(OrderPurchase::class, 'order_purchase_id');
    }
    public function rel_to_billinfo(){
        return $this->belongsTo(BillingInfo::class, 'billing_id');
    }

    public function rel_to_product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
