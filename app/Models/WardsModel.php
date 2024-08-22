<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardsModel extends Model
{
    use HasFactory;
    protected $table = 'wards';
    protected $fillable = [
        'wards_id',
        'district_id',
        'name'
    ];
}
