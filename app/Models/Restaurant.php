<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Models\WeekSchedule;
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
        return $this->hasMany(CategoryRestaurant::class);
    }

    public function addressInfo()
    {
        return $this->morphOne(Address::class , 'addressable');
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Cart::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
    }

    public function weekSchedules()
    {
        return $this->hasMany(WeekSchedule::class);
    }

    public function cart()
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
}
