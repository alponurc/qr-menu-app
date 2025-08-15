<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Product extends Model {
  use AsSource;
  use Filterable;
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'image',
    'price',
    'tags',
    'category',
    'weight',
    'calories',
    'is_new',
    'is_hot',
    'quantity',
    'is_recommended'
  ];

  protected $casts = [
    'tags' => 'array',
    'category' => 'array',
    'is_new' => 'boolean',
    'is_hot' => 'boolean',
    'is_recommended' => 'boolean',
  ];

  protected $allowedSorts = [
    'id',
    'name',
    'price',
    'weight',
    'calories',
    'is_new',
    'is_hot',
    'updated_at',
  ];

  protected $allowedFilters = [
    'id'             => Like::class,
    'name'           => Like::class,
    'price'          => Like::class,
    'weight'         => Like::class,
    'calories'       => Like::class,
    'is_new'         => Like::class,
    'is_hot'         => Like::class,
    'updated_at'     => Like::class,
  ];
}
