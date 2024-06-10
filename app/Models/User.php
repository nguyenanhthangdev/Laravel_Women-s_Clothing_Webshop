<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'username',
        'password',
        'email',
        'image',
        'fullname',
        'status',
        'phone',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    // Validation rules
    public static $rules = [
        'username' => 'required|string|max:255',
        'password' => 'required|string',
        'email' => 'required|string|email|max:255',
        'image' => 'nullable|string|max:255',
        'fullname' => 'nullable|string|max:255',
        'status' => 'boolean',
        'phone' => 'nullable|string|max:20',
    ];
}
