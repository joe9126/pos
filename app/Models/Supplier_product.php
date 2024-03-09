<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_product extends Model
{
    use HasFactory;
    protected $table = "supplier_product";

    protected $fillable = [
        'supplier_id','product_id','unit_cost', 'quantity','supply_term','user_id'	
    ];
}
