<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable = [
        'title','summary','location','region','category','date','application_deadline',
        'start_time','end_time','slots','requirements','status','poster_path'
    ];

    protected $casts = [
        'date' => 'date',
        'application_deadline' => 'date',
    ];
}
