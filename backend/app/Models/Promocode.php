<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;

use Orchid\Screen\AsSource;
use Orchid\Filters\Types\Like;

class Promocode extends Model {
  use AsSource;
  use Filterable;
  use HasFactory;

  protected $connection = 'mysql';
  protected $table = 'promocodes';

  protected $fillable = [
    'code',
    'discount',
    'expires_at',
  ];

  protected $casts = [
    'expires_at' => 'date:M j, Y',
  ];

  protected $allowedSorts = [
    'id',
    'code',
    'discount',
    'expires_at',
    'updated_at',
  ];

  protected $allowedFilters = [
    'id'             => Like::class,
    'code'           => Like::class,
    'discount'       => Like::class,
    'expires_at'     => Like::class,
    'updated_at'     => Like::class,
  ];
}
