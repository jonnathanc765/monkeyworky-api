<?php

namespace App\Models;

use App\Utils\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    use ImageTrait;

    protected $fillable = [
        'position',
        'picture'
    ];

    const MAIN = 'main';
    const MAX_PER_POSITION = [
        Banner::MAIN => 5
    ];
}
