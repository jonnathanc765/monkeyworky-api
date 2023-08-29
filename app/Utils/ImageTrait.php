<?php

namespace App\Utils;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{

    /**
     * Remove previous image if it exists
     *
     * @param $image_path
     * @param $disk (default = 'public')
     */
    protected function deleteImage($image_path, $disk = 'public')
    {
        try {
            if (Storage::disk($disk)->exists($image_path)) {
                Storage::disk($disk)->delete($image_path);
            }
            return true;
        } catch (Exception $e) {
            return $e;
        }
    }

    protected function saveOneImage($file, $folder, $name, $disk = 'private')
    {
        $extension = $file->extension();
        $date = new Carbon();
        try {
            $path = Storage::disk($disk)->putFileAs($folder, $file, "$name ($date->timestamp).$extension");
            return $path;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * add files in model
     *
     * @param $request->files as $files
     * @param Voting voting
     */
    private function addFile($files, $model, $folder)
    {
        $path = [];
        foreach ($files as $row) :
            $file = $model->files()->create([
                'file' => $row->store("$folder/$model->id", 'private')
            ]);
            array_push($path, $file->file);
        endforeach;
        return $path;
    }

    /**
     * Delete image in case of revert
     *
     * @param $path
     */
    protected function rollBackFile($path)
    {
        foreach ($path as $row) :
            $this->deleteImage($row, 'private');
        endforeach;
    }
}
