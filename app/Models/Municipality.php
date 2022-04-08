<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'state_id',
        'name',
    ];

    /**
     * Get the state that owns the Municipality
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * Get all of the parishes for the Municipality
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parishes(): HasMany
    {
        return $this->hasMany(Parish::class, 'municipality_id');
    }
}
