<?php

namespace App\Helper;

use App\Exceptions\ImageUploadFailException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    public const ALLOW_IMAGE = ['jpeg', 'png', 'jpg', 'gif', 'svg'];
    public const DEFAULT_PATH = 'uploads';

    public static function upload($image, $fileName = null, $toPath = self::DEFAULT_PATH)
    {
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->extension();

        if (!in_array($extension, self::ALLOW_IMAGE)) {
            throw new ImageUploadFailException(
                'Image not allow, image allow with extension ' . implode(",", self::ALLOW_IMAGE)
            );
        }

        $uuid = Str::uuid();

        $name = "{$uuid}{$originalName}.$extension";

        $fileName = !is_null($fileName) ? "$fileName.$extension" : $name;

        $filePath = $image->storeAs($toPath, $fileName);
        Storage::url($filePath);
        return $filePath;
    }

    public static function uploadMulti($images, $fileName = null, $toPath = self::DEFAULT_PATH)
    {
        try {
            $arrayImage = [];
            foreach ($images as $image) {
                array_push($arrayImage, static::upload($image, $fileName, $toPath));
            }
            return $arrayImage;
        } catch (ImageUploadFailException $e) {
            static::deleteImages($arrayImage);
            throw $e;
        }
    }

    public static function deleteImages(array $images)
    {
        foreach ($images as $image) {
            static::deleteImage($image);
        }
    }

    public static function deleteImage($path)
    {
        Storage::delete($path);
    }

    public static function get($path)
    {
        return Storage::url($path);
    }
}