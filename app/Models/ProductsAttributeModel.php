<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttributeModel extends Model
{
    use HasFactory;
    protected $table='products_attribute';
    protected $fillable=[
        'product_id',
        'quantity',
        'price'
    ];
}
