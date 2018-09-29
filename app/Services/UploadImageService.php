<?php

namespace App\Services;

use App\Http\Requests\UploadImageRequest;

/**
 * Class UploadImageService
 * @package App\Services
 */
class UploadImageService
{
    public function upload(UploadImageRequest $request): string
    {
        $file = $request->file('photo');
        $path = $file->store('images');
        return $path;
    }
}
