<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "status",
        "cashier_id",
        "total"
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, "order_id", "id");
    }
}
