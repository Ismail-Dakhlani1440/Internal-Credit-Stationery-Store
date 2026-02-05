<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['quantity','satuts','user_id','product_id'];
}
