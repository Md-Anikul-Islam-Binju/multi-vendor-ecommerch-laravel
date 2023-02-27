<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, $id)
 */
class Cart extends Model
{
    protected $guarded = [];

    public function get_product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


}
