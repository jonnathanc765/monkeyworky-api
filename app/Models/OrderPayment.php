<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'bank_id',
        'owner',
        'destination',
        'email',
        'date',
        'voucher',
        'reference',
    ];

    protected $appends = [
        'voucher_url'
    ];

    /**
     * Get the order that owns the OrderPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Get the bank that owns the OrderPayment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    
    public function voucher()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function getVoucherUrlAttribute()
    {
        try {
            return $this->voucher->getUrl();
        } catch (\Throwable $th) {
            return null;
        }
    }

}
