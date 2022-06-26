<?php

namespace App\Models;

use App\Models\Food;
use App\Models\Image;
use App\Models\Comment;
use App\Models\FoodType;
use App\Models\WeekSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class , 'addressable');
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Food::class);
    }

    public function weekSchedules()
    {
        return $this->hasMany(WeekSchedule::class);
    }

    public function foods()
    {
        return $this->hasMany(Food::class);
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
        if (isset($value['food_type_id'])) {
            $query->where('food_type_id', $value['food_type_id']);
        }
        return $query;
    }
}
