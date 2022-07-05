<?php

namespace App\Models;

use App\Models\CartFood;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    // public function user()
    // {
    //     return $this->hasManyThrough(User::class, CartUser::class, 'cart_id', 'id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function cartFood()
    {
        return $this->hasMany(CartFood::class);
    }

    // public function cartRestaurants()
    // {
    //     return $this->hasMany(CartRestaurant::class);
    // }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
        // return $this->hasManyThrough(Restaurant::class, CartRestaurant::class, 'cart_restaurant.cart_id', 'restaurants.id');
    }

    public function foods()
    {
        return $this->hasManyThrough(Food::class, CartFood::class, 'cart_food.cart_id', 'food.id');
    }
}
