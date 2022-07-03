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
    protected $appends = ['distance'];

    public function getDistanceAttribute()
    {
        return rand(1,10);  
    }


    public function ScopeDistance($query, $from_latitude, $from_longitude, $distance)
    {
        // This will calculate the distance in km
        // if you want in miles use 3959 instead of 6371
        $raw = DB::raw('ROUND ( ( 6371 * acos( cos( radians(' . $from_latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $from_longitude . ') ) + sin( radians(' . $from_latitude . ') ) * sin( radians( latitude ) ) ) ) ) AS distance');
        return $query->select('*')->addSelect($raw)->orderBy('distance', 'ASC')->groupBy('distance')->having('distance', '<=', $distance);
    }

    public function category()
    {
        // TODO:check for using category in phase 1 & 2
        return $this->hasManyThrough(Category::class, CategoryRestaurant::class, 'restaurant_id', 'id');
    }

    public function addressInfo()
    {
        return $this->morphOne(Address::class , 'addressable');
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    // public function comments()
    // {
    //     return $this->hasManyThrough(Comment::class, Cart::class);
    // }

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
        return $this->belongsToMany(Cart::class, CartRestaurant::class);
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
