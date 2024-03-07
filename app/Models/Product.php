<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Taxgroup;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    use HasFactory;

    /**
     * Table for the model
     */
    protected $table  = 'product';
    protected $foreignKey = 'category_id';


    protected $fillable = [
        'sku','title','category_id','quantity','image','unit_price','discount','tax_id','status','stock_notice'
    ];

      /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    /**
     * One product belongs to one tax group
     */
    public function taxgroup(): BelongsTo{
        return $this->belongsTo(Taxgroup::class);
    }

    /**
     * One product belongs to many transactions
     */
    public function transaction():BelongsToMany{
        return $this->belongsToMany(Transaction::class);
    }
}
