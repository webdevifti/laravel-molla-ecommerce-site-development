<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function relWithCustomer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function relWithOrder(){
        return $this->belongsTo(OrderPurchase::class, 'id');
    }
}
