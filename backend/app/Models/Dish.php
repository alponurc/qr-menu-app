<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    /**
     * Veritabanında toplu atama (mass assignment) için izin verilen alanlar.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'favorite_count',
        // Eğer başka alanlar varsa buraya ekleyebilirsin
    ];
}
