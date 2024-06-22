<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class UserImageService
{
    public function storeImage($request, string $dir, bool $make_thumb, array $thumb_values): array
    {
        $directory = '/app/'.$dir.'/';
        $image = '';

        if ($request->file('image') !== null) {
            $image = $request->file('image')->store('', $dir);
            ImageOptimizer::optimize(storage_path().$directory.$image);
            if ($make_thumb) {
                $result = $this->generate_thumb($image, $dir, $thumb_values);
            }
            $file_name = $request->image->getClientOriginalName();
        }

        return [
            'image' => $image ?? '',
            'file_name' => $file_name ?? '',
            'thumb' => $result ?? '',
        ];
    }

    /**
     * @throws InvalidManipulation
     */
    public function updateImage($request, string $dir, bool $make_thumb, array $thumb_values): array
    {

        /** @var TYPE_NAME $directory */
        $directory = '/app/'.$dir.'/';

        if ($request->file('image') !== null) {
            $image = $request->file('image')->store('', $dir);

            ImageOptimizer::optimize(storage_path().$directory.$image);

            if ($make_thumb) {
                $result = $this->generate_thumb($image, $dir, $thumb_values);
            }
            $file_name = $request->image->getClientOriginalName();
        }

        return [
            'image' => $image ?? '',
            'file_name' => $file_name ?? '',
            'thumb' => $result ?? '',
        ];
    }

    /**
     * @throws InvalidManipulation
     */
    public function generate_thumb($image, $dir, $thumb_values): string
    {
        $directory = '/app/'.$dir.'/';
        $w = $thumb_values['width'];
        $h = $thumb_values['height'];

        Image::load(storage_path().$directory.$image)
            ->width($w)
            ->height($h)
            ->save(storage_path().$directory.$thumb_values['tn_str'].$image);

        return $thumb_values['tn_str'].$image;
    }

    public function destroyImage(string $image, string $dir, array $thumb_values): bool
    {
        Storage::disk($dir)->delete($image);
        Storage::disk($dir)->delete($thumb_values['tn_str'].$image);

        return true;
    }
}
