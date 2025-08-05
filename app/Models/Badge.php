<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $fillable = [
        'name', 'icon', 'description', 'hours_required', 'events_required', 'auto_award'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('awarded_at');
    }
}
