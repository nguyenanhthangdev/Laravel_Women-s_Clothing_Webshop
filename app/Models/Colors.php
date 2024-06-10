<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    use HasFactory;

    protected $table = 'colors';
    protected $primaryKey = 'color_id';
    protected $fillable = ['name'];

    public function variants()
    {
        return $this->hasMany(ProductVariants::class, 'color_id', 'color_id');
    }
}
