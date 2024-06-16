<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'shipping';

    // Khóa chính
    protected $primaryKey = 'shipping_id';

    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = [
        'fullname',
        'email',
        'phone_number',
        'address_type',
        'status',
        'customer_id',
        'address_specific',
        'city_id',
        'district_id',
        'ward_id',
    ];

    // Các quan hệ (relationships)

    // Quan hệ với model Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Quan hệ với model City
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    // Quan hệ với model Province
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    // Quan hệ với model Ward
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
}
