<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTopping extends Model
{
    use HasFactory;

    protected $table = 'category_topping';

    protected $fillable = [
        'id_category',
        'id_topping',
        'state'
    ];
}
