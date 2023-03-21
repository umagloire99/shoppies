<?php

namespace App\Services;

use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\File;

class ImageService
{
    use ImageUploadTrait;

    private string $folder;
    public function __construct($folder = 'products')
    {
        $this->folder = $folder;
    }

    public function storeProductImages($images, $product, $i = 1)
    {
        foreach ($images as $image) {
            $size = $image->getSize();
            $type = $image->getMimeType();
            $product->media()->create([
                'file_name' => $this->uploadImages($product->name, $image, $i, $this->folder, 540, 720),
                'file_size' => $size,
                'file_type' => $type,
                'file_status' => true,
                'file_sort' => $i
            ]);

            $i++;
        }
    }

    public function storeUserImages($fileName, $image): string
    {
        return $this->uploadImage(
            $fileName,
            $image,
            'users',
            300,
            NULL
        );
    }

    public function unlinkImage($image, $folderName)
    {
        if (File::exists('storage/images/'. $folderName .'/' . $image)) {
            unlink('storage/images/'. $folderName .'/' . $image);
        }
    }
}
