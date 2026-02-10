<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
        'SKU',
        'name',
        'description',
        "price",
        "stock",
        "categories"
    ];
}
