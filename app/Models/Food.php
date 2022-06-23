<?php

namespace App\Models;

use App\Models\FoodType;
use App\Models\FoodParty;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'food_party_id',
        'food_type_id',
        'status',
        'image',
        'status'
    ];
    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    function foodParty()
    {
        return $this->belongsTo(FoodParty::class);
    }

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'active' : 'inactive',
            set: fn($value) => $value == 'active' ? true : false,
        );
    }


}
