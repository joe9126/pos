<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $primaryKey = 'id';

    protected $fillable = [
        'taxrate','discount','grandtotal','soldby'
    ];

    /**
     *  A Transaction has many products
     */
    public function product():BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot('unitprice','units','subtotal');
    }
}
