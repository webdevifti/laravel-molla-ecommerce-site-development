<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_fullname',
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
}
