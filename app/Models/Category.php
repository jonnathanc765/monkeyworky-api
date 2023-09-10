<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'picture_url'
    ];

    /**
     * Get all of the subCategories for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }

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
