<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_order extends Model
{
    protected $fillable = ['quantity','satuts','user_id','product_id'];
}
