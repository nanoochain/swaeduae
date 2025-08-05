<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opportunity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'region', 'start_date', 'end_date', 'max_volunteers', 'image', 'created_by'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
    public function volunteerHours()
    {
        return $this->hasMany(VolunteerHour::class);
    }
}
