<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restockrequest;

class Product_restockrequest extends Model
{
    use HasFactory;

    protected $table = 'product_restockrequest';

    protected $fillable = [
        'restockrequest_id','product_id','quantity','status'
    ];

    /**
     * A request/requestItem belongs to a single Restockrequest 
     */
    public function restockrequest():BelongsTo{
        return $this->belongsTo(Restockrequest::class);
    }
}
