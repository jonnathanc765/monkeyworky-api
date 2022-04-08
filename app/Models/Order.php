<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const REFUSED = 'refused'; // RECHAZADA POR UN ADMIN
    const CANCELED = 'canceled'; // CANCELADA POR EL CLIENTE
    const PENDING_FOR_PAYMENT = 'pending_for_payment'; // ESPERANDO PAGO DEL CLIENTE
    const ADDED_PAYMENT = 'added_payment'; // PAGO AÑADIDO
    const APPROVED_PAYMENT = 'approved_payment'; // PAGO APROBADO POR UN ADMIN
    const ON_HOLD = 'order_on_hold'; // ORDEN EN ESPERA PARA SER TRANSPORTADA
    const ON_THE_WAY = 'order_on_the_way'; // ORDEN SIENDO TRANSPORTADA
    const PENDING_BY_CUSTOMER = 'order_pending_by_customer'; // ORDEN EN EL DESTINO, ESPERANDO SER RECOGIDO POR EL CLIENTE
    const DELIVERED = 'order_delivered'; // ORDEN ENTREGADA

    protected $fillable = [
        'user_id',
        'type_id',
        'total',
        'total_bs',
        'status',
    ];

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the address associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class, 'order_id');
    }

    /**
     * Get the type that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DeliveryManagement::class, 'type_id');
    }

    /**
     * Get the payment associated with the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    /**
     * Get all of the products for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }
}
