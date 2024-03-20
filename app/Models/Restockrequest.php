<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
use App\Models\User;

class Restockrequest extends Model
{
    use HasFactory;
protected $table = 'restock_request';

protected $fillable = [
    'user_id','status'
];
/**
 * A product belonging to a request
 */
public function product():BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * A restock request has one user
     */

     public function user():BelongsTo{
        return $this->belongsTo(User::class);
     }
}
