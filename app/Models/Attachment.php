<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Attachment extends Model
{
    use HasFactory;
    protected static function boot() {
        parent::boot();

        static::deleting(function($attachment) {
            $attachment->blob->delete();
        });
    }

    public function attachable()
    {
        return $this->morphTo();
    }

    public function blob()
    {
        return $this->hasOne(Blob::class);
    }

    public function getUrl()
    {
        return "/attachments/$this->id";
    }

    public function attach(UploadedFile $file)
    {
        $this->blob()->create([
            'mimetype' => $file->getClientMimeType(),
            'filename' => $file->getClientOriginalName(),
            'path' => $file->store('attachments')
        ]);
    }
}
