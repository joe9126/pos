<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $table = "store_settings";

    protected $fillable = [
        'store_name','slogan','address','telephone','email','logo','low_stock_level',
    ];
}
