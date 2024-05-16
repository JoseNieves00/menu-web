<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVersion extends Model
{
    use HasFactory;

    protected $table = 'product_version';

    protected $fillable = [
        'id_product',
        'name',
        'price',
        'state'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
