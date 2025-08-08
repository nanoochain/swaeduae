<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerHour extends Model
{
    protected $fillable = ['user_id','date','hours','notes','event_id','status'];
    protected $casts = ['date' => 'date', 'hours' => 'float'];
}
