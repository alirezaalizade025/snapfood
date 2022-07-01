<?php

namespace App\Models;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartRestaurant extends Model
{
    use HasFactory;
    protected $table = 'cart_restaurant';

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
