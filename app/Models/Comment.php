<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\CartFood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function cartFood()
    {
        return $this->belongsTo(CartFood::class);
    }
}
