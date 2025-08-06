<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'date',
        'organization_id',
        // add any other columns you use
    ];

    // Relationships
    public function organization() {
        return $this->belongsTo(\App\Models\User::class, 'organization_id');
    }

    // Add other relationships if needed
}
