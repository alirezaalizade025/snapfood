<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Food;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartFood extends Model
{
    use HasFactory;
    protected $table = 'cart_food';

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
