<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address1',
        'address2',
        'address3',
        'address4',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
