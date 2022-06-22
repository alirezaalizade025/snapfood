<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodParty extends Model
{
    use HasFactory;

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'active' : 'inactive',
            set: fn($value) => $value == 'active' ? true : false,
        );
    }
}
