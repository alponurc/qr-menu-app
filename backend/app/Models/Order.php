<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class Order extends Model {
  use AsSource;
  use HasFactory;
  use Filterable;

  protected $connection = 'mysql';
  protected $table = 'orders';

  protected $fillable = [
    'total_price',
    'status',
    'delivery',
    'discount',
    'products',
    'name',
    'email',
    'user_id',
    'address',
    'phone_number',
    'order_status',
    'payment_status',
    'delivery_price',

  ];

  protected $allowedFilters = [
    'name'       => Like::class,
    'phone_number'      => Like::class,
    'total_price'  => Like::class,
    'order_status' => Like::class,
  ];

  protected $casts = [
    'products' => 'array',
  ];

  protected $allowedSorts = [
    'id',
    'full_name',
    'phone_number',
    'total_price',
    'order_status',
  ];

  public function products() {
    return $this->hasMany(Product::class);
  }
}
