<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Tax extends Model
{
    use HasFactory;
    protected $table = 'taxgroup';

    protected $fillable = [
        'title','rate','status'
    ];

    /**
     * One taxgroup has many products
     */
    public function product():hasMany{
        return $this->hasMany(Product::class);
    }
}
