<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = "supplier";
    protected $fillable = [
        'title','description','telephone','email','address','tax_pin'
    ];

    /**
     * Supplier has many products
     */
    public function product():BelongsToMany{
        return $this->belongsToMany(Product::class);
    }
}
