<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'date', 'organization_id'
    ];

    public function organization() {
        return $this->belongsTo(\App\Models\User::class, 'organization_id');
    }
}
