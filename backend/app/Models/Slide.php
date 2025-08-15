<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Filterable;

class Slide extends Model {
  use AsSource;
  use HasFactory;
  use Filterable;

  protected $fillable = [
    'image',
  ];

  protected $allowedSorts = [
    'id',
    'updated_at',
  ];

  protected $allowedFilters = [
    'id'         =>  Like::class,
    'updated_at' => Like::class,
  ];
}
