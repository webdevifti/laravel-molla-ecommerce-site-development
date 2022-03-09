<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPurchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function WithCustomer(){
        return $this->hasMany(Customer::class, 'customer_id');
    }
    public function relWithBillInfo(){
        return $this->belongsTo(BillingInfo::class, 'billing_id');
    }
}
