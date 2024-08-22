<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTotalModel extends Model
{
    use HasFactory;
    protected $table='order_total';
    protected $fillable=[
        'order_id',
        'type_payment',
        'total_product',
        'total_shipping_fee',
        'exchange_points',
        'total_payment',
        ];
}
