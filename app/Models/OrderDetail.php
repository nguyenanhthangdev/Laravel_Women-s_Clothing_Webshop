<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    
    protected $table = 'order_detail';
    protected $primaryKey = 'order_detail_id';
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'unit_price',
        'total_price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariants::class, 'product_variant_id');
    }
}
