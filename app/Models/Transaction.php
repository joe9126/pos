<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $primaryKey = 'id';

    protected $fillable = [
        'subtotal','taxrate','discount','grandtotal','payment','payment_mode','user_id','status'
    ];

    /**
     *  A Transaction has many products
     */
    public function product():BelongsToMany{
        return $this->belongsToMany(Product::class)->withPivot('unitprice','units','subtotal');
    }

    /**
     * A transaction belongs to one user
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
