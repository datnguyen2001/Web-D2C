<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddressModel extends Model
{
    use HasFactory;
    protected $table='delivery_address';
    protected $fillable=[
        'user_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'ward_id',
        'address_detail',
        'display'
    ];
}
