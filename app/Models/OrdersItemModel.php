<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersItemModel extends Model
{
    use HasFactory;
    protected $table = 'orders_item';
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total_money'
    ];
}
