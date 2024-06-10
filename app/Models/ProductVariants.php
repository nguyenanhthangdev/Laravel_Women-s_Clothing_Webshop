<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariants extends Model
{
    use HasFactory;

    protected $table = 'product_variants';
    protected $primaryKey = 'product_variant_id';
    protected $fillable = ['product_id', 'size_id', 'color_id', 'image', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Sizes::class, 'size_id', 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Colors::class, 'color_id', 'color_id');
    }
}
