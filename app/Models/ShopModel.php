<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopModel extends Model
{
    use HasFactory;
    protected $table='shop';
    protected $fillable=[
        'user_id',
        'name',
        'phone',
        'email',
        'scope',
        'province_id',
        'district_id',
        'ward_id',
        'address_detail',
        'content',
        'avatar',
        'banner',
        'src',
        'display'
    ];
}
