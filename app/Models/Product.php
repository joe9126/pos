<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Taxgroup;
use App\Models\Transaction;
use App\Models\Supplier;
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
        'sku','title','category_id','quantity','image','unit_price','discount','tax_id','status','stock_notice','rating'
    ];

      /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    /**
     * One product belongs to one taxgroup
     */
    public function tax(): BelongsTo{
        return $this->belongsTo(Tax::class);
    }

    /**
     * A product has many transactions
     */
    public function transaction():BelongsToMany{
        return $this->belongsToMany(Transaction::class);
    }

     /**
     * A product has many Suppliers
     */
    public function supplier():BelongsToMany{
        return $this->belongsToMany(Supplier::class);
    }

    // Scope to search products by title, SKU, or category
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($query) use ($keyword) {
            $query->where('title', 'like', "%".$keyword."%")
                  ->orWhere('sku', $keyword)
                  ->orWhereHas('category', function ($query) use ($keyword) {
                      $query->where('title', $keyword);
                  });
        });
    }
}
