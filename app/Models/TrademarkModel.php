<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrademarkModel extends Model
{
    use HasFactory;
    protected $table='trademark';
    protected $fillable=[
      'src',
      'display'
    ];
}
