<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait ImageCompressor
{
    /**
     * Compress image using GD and store it in the specified directory.
     *
     * @param UploadedFile $file The uploaded file
     * @param string $directory The directory to store the file (e.g., 'pakets', 'galleries')
     * @return string The path to the stored file
     */
    public function compressAndStoreImage(UploadedFile $file, string $directory): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = $directory . '/' . uniqid() . '_' . time() . '.jpg';

        // Create image resource from uploaded file
        $image = match ($extension) {
            'png' => imagecreatefrompng($file->getRealPath()),
            'gif' => imagecreatefromgif($file->getRealPath()),
            'webp' => imagecreatefromwebp($file->getRealPath()),
            default => imagecreatefromjpeg($file->getRealPath()),
        };

        if (!$image) {
            // Fallback: store without compression if GD fails
            return $file->store($directory, 'public');
        }

        // Resize if too large (max 1920px width)
        $width = imagesx($image);
        $height = imagesy($image);
        $maxWidth = 1920;

        if ($width > $maxWidth) {
            $newHeight = (int) ($height * ($maxWidth / $width));
            $resized = imagecreatetruecolor($maxWidth, $newHeight);

            // Preserve transparency for PNG (though we save as JPG, it helps processing)
            if ($extension === 'png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        // Save as JPEG with 75% quality
        $storagePath = storage_path('app/public/' . $filename);
        $dir = dirname($storagePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        imagejpeg($image, $storagePath, 75);
        imagedestroy($image);

        return $filename;
    }
}
