<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sub_category_id',
        'name',
    ];

    /**
     * Get all of the variations for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class, 'product_id');
    }

    /**
     * Get the subCategory that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    protected $appends = [
        'picture_url'
    ];

    public function picture()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function getPictureUrlAttribute()
    {
        try {
            return $this->picture->getUrl();
        } catch (\Throwable $th) {
            return null;
        }
    }
}
