<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Drawer extends Model
{
    use HasFactory;

    protected $table = 'drawer';

    protected $fillable = [
        'user_id','opening_balance','cash_float',
        'today_sales','expected_amount',
        'counted_amount','remark','cash_balance'
    ];

    /**
     * Drawer belongs to user
     */
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
