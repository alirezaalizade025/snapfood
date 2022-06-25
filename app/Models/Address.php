<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $hidden = [
        'addressable_type',
        'addressable_id'
    ];

    protected $guarded = [];

    public function addressable()
    {
        return $this->morphTo();
    }

}
