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

    public function user()
    {
        return $this->hasManyThrough(User::class, CartUser::class, 'cart_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function cartFood()
    {
        return $this->hasMany(CartFood::class);
    }
}
