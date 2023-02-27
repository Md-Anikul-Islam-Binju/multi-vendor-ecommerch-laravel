<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $attributes)
 */
class ReturnRequest extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'products', 'reason'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
