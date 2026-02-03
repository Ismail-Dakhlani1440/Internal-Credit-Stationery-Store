<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','stock','premium','categorie_id'];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class)->withPivot('quantity' ,'satuts')->withTimestamps();
    }
}
