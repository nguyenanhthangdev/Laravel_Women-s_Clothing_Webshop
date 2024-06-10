<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sizes extends Model
{
    use HasFactory;

    protected $table = 'sizes';
    protected $primaryKey = 'size_id';
    protected $fillable = ['name'];

    public function variants()
    {
        return $this->hasMany(ProductVariants::class, 'size_id', 'size_id');
    }
}
