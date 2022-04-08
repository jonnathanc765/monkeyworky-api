<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'size_id',
        'price',
    ];

    /**
     * Get the size that owns the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size(): BelongsTo
    {
        return $this->belongsTo(VariationSize::class, 'size_id');
    }

    /**
     * Get the product that owns the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get all of the shoppingCarts for the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingCart(): HasMany
    {
        return $this->hasMany(ShoppingCart::class, 'variation_id');
    }

    /**
     * Get all of the orderProduct for the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderProduct(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'variation_id');
    }
}
