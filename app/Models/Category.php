<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function restaurants()
    {
        return $this->hasManyThrough(Restaurant::class, CategoryRestaurant::class, 'category_id', 'id', 'id', 'restaurant_id');
    }
}
