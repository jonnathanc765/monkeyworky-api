<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Blob extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot() {
        parent::boot();

        static::deleting(function($blob) {
            Storage::delete($blob->path);
        });
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
