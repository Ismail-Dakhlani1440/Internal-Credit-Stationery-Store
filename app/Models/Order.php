<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB ;

class Order extends Model
{

    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['total_price','user_id','status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class , 'product_order')->withPivot('quantity','tokens_required','status')->withTimestamps();
    }
    public function status()
    {
        $items = DB::table('product_order')
            ->where('order_id',$this->id)
            ->get();

        $total = $items->count();
        $approved = $items->where('status','approved')->count();
        $pending = $items->where('status','pending')->count();
        $rejected = $items->where('status','rejected')->count();

        if ($approved === $total) {
            $this->status = 'approved';
        } elseif ($pending > 0) {
            $this->status = 'pending';
        } elseif ($approved > 0 && $rejected > 0) {
            $this->status = 'partial';
        } else {
            $this->status = 'rejected';
        }

        $this->save();
    }
}
