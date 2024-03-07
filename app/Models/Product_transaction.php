<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Transaction;

class Product_transaction extends Model
{
    use HasFactory;

    /**
     *  This is a pivot table for Product_Transaction relationship (many-to-many)
     */

    protected $table = 'product_transaction';
    protected $foreignKey = ['transaction_id','product_id'];

    protected $fillable = [
        'transaction_id','product_id','unitprice','units','subtotal'
    ];

    
}
