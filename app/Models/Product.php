<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product'; // Đặt tên bảng

    protected $primaryKey = 'product_id'; // Đặt khóa chính

    protected $fillable = ['name', 'description', 'image', 'discount', 'manufacturer_id', 'featured', 'new', 'best_seller', 'status']; // Các cột có thể gán dữ liệu từ mass assignment

    // Định nghĩa mối quan hệ với model Manufacturer
    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'manufacturer_id');
    }

    // Định nghĩa mối quan hệ nhiều-nhiều với model Category
    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    public function productGallery()
    {
        return $this->hasMany(ProductGallery::class, 'product_id', 'product_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariants::class, 'product_id', 'product_id');
    }

    public function getMinPriceAttribute()
    {
        return $this->variants->min('price');
    }

    public function getMaxPriceAttribute()
    {
        return $this->variants->max('price');
    }
}
