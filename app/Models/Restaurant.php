<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Models\WeekSchedule;
use App\Models\CartRestaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function category()
    {
        // TODO:check for using category in phase 1 & 2
        return $this->hasManyThrough(Category::class, CategoryRestaurant::class, 'restaurant_id', 'id', 'id', 'category_id');
    }

    public function addressInfo()
    {
        return $this->morphOne(Address::class , 'addressable');
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function weekSchedules()
    {
        return $this->hasMany(WeekSchedule::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'active' : 'inactive',
            set: fn($value) => $value == 'active' ? true : false,
        );
    }


    public function scopeFilter($query, $value)
    {
        if (isset($value['is_open'])) {
            $query->where('status', true);
        }
        return $query;
    }

    //find restaurant score by average of all comments score in relation to restaurant
    public function getScore()
    {
        $comments = $this->carts->map(fn($cart) => $cart->comments)->first();
        return number_format(optional(optional($comments)->map(fn($comment) => $comment->score))->avg(), 2);
    }

}
