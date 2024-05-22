<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toppings extends Model
{
    use HasFactory;


    protected $table = 'topping';

    protected $fillable = [
        'name',
        'price',
        'id_topping',
        'id_category',
        'state'
    ];

    
    public function categoriesTopping()
    {
        return $this->hasMany(CategoryTopping::class, 'id_topping','id');
    }
}
