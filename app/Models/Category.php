<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category'; // Đặt tên bảng

    protected $primaryKey = 'category_id'; // Đặt khóa chính

    protected $fillable = ['name', 'image', 'featured', 'status'];

    // Định nghĩa mối quan hệ nhiều-nhiều với model Product
    public function product()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}

