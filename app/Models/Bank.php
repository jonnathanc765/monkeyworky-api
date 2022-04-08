<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'owner',
        'email',
        'phone',
        'dni',
        'account_number',
        'type',
    ];

    /**
     * Get all of the orderPaymens for the Bank
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderPaymens(): HasMany
    {
        return $this->hasMany(OrderPayment::class, 'bank_id');
    }
}
