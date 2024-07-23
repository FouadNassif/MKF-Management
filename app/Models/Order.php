<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "status",
        "type",
        "cashier_id",
        "driver_id",
        "customer_id",
        'waiter_id',
        "total"
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }

    public function customer() {
        return $this->belongsTo(User::class, "customer_id", "id");
    }
}
