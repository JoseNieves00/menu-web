<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'price',
        'id_product_category',
        'description',
        'url_image',
        'state'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'id_product_category');
    }
}
