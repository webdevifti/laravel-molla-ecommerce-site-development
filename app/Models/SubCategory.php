<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    function relationCategory(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subcategoryAddedUser(){
        return $this->belongsTo(User::class,'user_id');
    }
}
