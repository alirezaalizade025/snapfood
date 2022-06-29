<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\CartFood;
use App\Models\Category;
use App\Models\FoodParty;
use App\Models\Restaurant;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [

    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    function foodParty()
    {
        return $this->belongsTo(FoodParty::class);
    }

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class , 'imageable');
    }

    public function carts()
    {
        return $this->hasManyThrough(Cart::class, CartFood::class);
    }

    public function cartFood()
    {
        return $this->hasMany(CartFood::class);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'active' : 'inactive',
            set: fn($value) => $value == 'active' ? true : false,
        );
    }
}
