<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'state',
    ];

    public function categoriesTopping()
    {
        return $this->hasMany(CategoryTopping::class, 'id_category','id');
    }

}
