<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Add 'role' to the fillable array if you use mass assignment
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role',
    ];

    // Hide the password and remember_token fields
    protected $hidden = [
        'password', 'remember_token',
    ];
}
