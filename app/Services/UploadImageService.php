<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadImageService
{
    protected $file_disk;

    public function __construct()
    {
        $this->file_disk = config('filesystems.default');
    }

    /**
     * Update image user
     * @param $image
     * @param $folder
     *
     * @return array
     */
    public function uploadImage($image, $folder = null)
    {
        $image = $this->handleUploadImage($image, $folder);

        return $image;
    }

    /**
     * @param UploadedFile $file
     * @param $folder
     * @return array
     */
    protected function handleUploadImage(UploadedFile $file, $folder = null)
    {
        $fileName = $file->getClientOriginalName();
        $filePath = $file->storePublicly($folder, $this->file_disk);
        $fileUrl = Storage::url($filePath);

        $image = [
            // 'url' => $fileUrl,
            'path' => $filePath,
            'name' => $fileName,
        ];

        return $image;
    }

    /**
     * Delete image
     * @param $imageName
     */
    public function removeImage($path)
    {
        Storage::disk($this->file_disk)->delete($path);
    }
}
