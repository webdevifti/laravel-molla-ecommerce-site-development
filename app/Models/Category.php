<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function categoryAddedUser(){
        return $this->belongsTo(User::class,'added_by');
    }
    public function relationSubCategory(){
        return $this->hasMany(SubCategory::class, 'id');
    }
    public function relToProduct(){
        return $this->hasMany(Product::class, 'id');
    }
}
