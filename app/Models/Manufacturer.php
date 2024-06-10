<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $table = 'manufacturers'; // Đặt tên bảng

    protected $primaryKey = 'manufacturer_id'; // Đặt khóa chính

    protected $fillable = ['name', 'image', 'featured', 'status'];

    // Định nghĩa mối quan hệ một-nhiều với model Product
    public function product()
    {
        return $this->hasMany(Product::class, 'manufacturer_id', 'manufacturer_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
