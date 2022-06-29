<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->hasManyThrough(User::class, CartUser::class, 'cart_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
