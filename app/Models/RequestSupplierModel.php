<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSupplierModel extends Model
{
    use HasFactory;
    protected $table='request_supplier';
    protected $fillable=[
        'user_id',
        'name',
        'name_en',
        'slug',
        'content',
        'content_en',
        'phone',
        'quantity',
        'scope',
        'date_end',
        'src',
        'display',
        'status',
    ];
}
