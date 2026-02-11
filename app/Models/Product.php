<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['name','stock','image','premium','tokens_required','categorie_id'];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class , 'product_order')->withPivot('quantity','tokens_required','status')->withTimestamps();
    }
}
