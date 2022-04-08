<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    /**
     * Get all of the people for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function people(): HasMany
    {
        return $this->hasMany(People::class, 'state_id');
    }

    /**
     * Get all of the municipalities for the State
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class, 'state_id');
    }
}
