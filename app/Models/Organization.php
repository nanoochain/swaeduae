<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'kyc_document',
    ];

    protected $hidden = ['password'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
