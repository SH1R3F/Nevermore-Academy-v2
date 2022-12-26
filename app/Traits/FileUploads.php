<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait FileUploads
{
    public function upload(UploadedFile $file, string $path, string $disk = 'public'): string
    {
        return $file->store($path, ['disk' => $disk]);
    }
}
