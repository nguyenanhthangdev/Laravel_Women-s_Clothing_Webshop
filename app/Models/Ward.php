<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'ward';
    protected $primaryKey = 'ward_id';
    protected $fillable = ['ward_name', 'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    // Quan hệ với model Shipping
    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }
}
