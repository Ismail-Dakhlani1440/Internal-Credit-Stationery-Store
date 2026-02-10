<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['total_price','status','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity' ,'satuts')->withTimestamps();
    }
}
