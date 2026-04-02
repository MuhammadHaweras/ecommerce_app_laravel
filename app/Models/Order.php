<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number',
        'total_amount', 'status',
        'stripe_payment_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function OrderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
