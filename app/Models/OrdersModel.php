<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table='orders';
    protected $fillable=[
        'order_code',
        'shop_id',
        'user_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address_detail',
        'note',
        'shipping_unit',
        'commodity_money',
        'shipping_fee',
        'total_payment',
        'status',
    ];
}
