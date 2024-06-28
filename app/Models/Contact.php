<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'contact_id';
    protected $fillable = [
        'title',
        'detail',
        'name',
        'phone',
        'email',
    ];
}
