<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'district';
    protected $primaryKey = 'district_id';
    protected $fillable = ['district_name, city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function ward()
    {
        return $this->hasMany(Ward::class, 'district_id', 'district_id');
    }

    // Quan hệ với model Shipping
    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }
}
