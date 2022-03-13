<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function relWithBill(){
        return $this->belongsTo(BillingInfo::class,'customer_id');
    }

    public function relToOrderPurchase(){
        return $this->belongsTo(OrderPurchase::class, 'id');
    }
}
