<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VariationSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'size'
    ];

    /**
     * Get all of the variations for the VariationSize
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class, 'size_id');
    }
}
