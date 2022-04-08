<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'people_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the people that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function people(): BelongsTo
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    /**
     * Get all of the shoppingCarts for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shoppingCart(): HasMany
    {
        return $this->hasMany(ShoppingCart::class, 'user_id');
    }

    /**
     * Get all of the addresses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Get all of the fromMessages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fromMessages(): HasMany
    {
        return $this->hasMany(Conversation::class, 'from_id');
    }

    /**
     * Get all of the toMessages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function toMessages(): HasMany
    {
        return $this->hasMany(Conversation::class, 'to_id');
    }

    /**
     * Get all of the orders for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Get all of the notifications for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    /* EMAILS */

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /* FUNCTIONS */

    public function isAdmin(): bool
    {
        return ($this->roles[0]->name === 'admin');
    }

    public function isCustomer(): bool
    {
        return ($this->roles[0]->name === 'customer');
    }
}
