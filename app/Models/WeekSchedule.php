<?php

namespace App\Models;

use App\Casts\ScheduleCast;
use App\Casts\ScheduleTimeCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeekSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'day' => ScheduleCast::class ,
        'start' => ScheduleTimeCast::class ,
        'end' => ScheduleTimeCast::class ,
    ];
}
