<?php

namespace App\Models;

use App\Utils\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    use ImageTrait;

    const MAIN = 'main';
    const MAX_PER_POSITION = [
        Banner::MAIN => 5
    ];

    protected $fillable = [
        'position',
    ];

    protected $appends = [
        'picture_url'
    ];

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
