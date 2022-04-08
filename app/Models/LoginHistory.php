<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LoginHistory extends Authenticatable
{
    use HasFactory;

    protected $table = 'login_histories';


    protected $fillable = [
        'user_id',
        'ip',
        'api_token',
    ];

    protected  $hidden = [
        'api_token',
    ];

    /**
     * Get the user that owns the LoginHistory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
