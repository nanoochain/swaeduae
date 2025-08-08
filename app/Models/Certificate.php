<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['user_id','event_id','code','issued_at','status'];
    protected $casts = ['issued_at' => 'datetime'];
}
