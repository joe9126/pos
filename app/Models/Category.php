<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'id';



    protected $fillable = [
        'title','image','status'
    ];

     /**
     * Get the products for the category.
     */

    public function product(): HasMany{
        return $this->hasMany(Product::class);
    }
}
