<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFile
{
    public function uploadFile(UploadedFile $file, string $folder = 'uploads', string $disk = 'public')
    {
        $filename = time() . '_' . strtolower(str_replace(' ', '_', $file->getClientOriginalName()));
        $path=$file->storeAs($folder, $filename, $disk);
        return Storage::url($path);
    }
}
