<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_firstname',
        'customer_lastname',
        'customer_username',
        'customer_email',
        'customer_photo',
        'customer_password',
        'customer_phone_number',
        'customer_status',
        'customer_address',
        'customer_zipcode',
        'is_verified'
    ];


    // public function relWithBill(){
    //     return $this->belongsTo(BillingInfo::class, 'id','customer_id');
    // }

    public function relToOrderPurchase(){
        return $this->hasMany(OrderPurchase::class, 'id');
    }
}
