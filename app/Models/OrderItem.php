<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        "quantity",
        "order_id",
        "item_id"
    ];

    public function order() {
        return $this->hasOne(Order::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
