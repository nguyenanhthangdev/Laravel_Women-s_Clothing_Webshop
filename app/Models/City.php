<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'city';
    protected $primaryKey = 'city_id';
    protected $fillable = ['city_name'];

    public function district()
    {
        return $this->hasMany(District::class, 'city_id', 'city_id');
    }

     // Quan hệ với model Shipping
     public function shipping()
     {
         return $this->hasMany(Shipping::class, 'city_id');
     }
}
