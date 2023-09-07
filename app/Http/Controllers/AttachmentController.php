<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;


class AttachmentController extends Controller {
  public function download(Attachment $attachment)
    {
        $blob = $attachment->blob;

        return Storage::download($blob->path, $blob->filename);
    }
}