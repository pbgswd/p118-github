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
        $directory = '/app/' . $dir . '/';
        $image ='';

        if (null !== $request->file('image')) {
            $image = $request->file('image')->store('', $dir);
            ImageOptimizer::optimize(storage_path() . $directory . $image);
            if($make_thumb) {
                $result = $this->generate_thumb($image, $dir, $thumb_values);
            }
            $file_name = $request->image->getClientOriginalName();
        }

        return [
            'image' => $image ?? '',
            'file_name' => $file_name ?? '',
            'thumb' =>  $result ?? '',
        ];
    }

    /**
     * @param $request
     * @param string $dir
     * @param bool $make_thumb
     * @param array $thumb_values
     * @return array
     * @throws InvalidManipulation
     */
    public function updateImage($request, string $dir, bool $make_thumb, array $thumb_values): array
    {

        /** @var TYPE_NAME $directory */
        $directory = '/app/' . $dir . '/';

        if (null !== $request->file('image')) {
            /**
             * @var $image
             */
            $image = $request->file('image')->store('', $dir);

            ImageOptimizer::optimize(storage_path() . $directory . $image);

            if($make_thumb) {
                $result = $this->generate_thumb($image, $dir, $thumb_values);
            }
            $file_name = $request->image->getClientOriginalName();
        }

        return [
            'image' => $image ?? '',
            'file_name' => $file_name ?? '',
            'thumb' =>  $result ?? '',
        ];
    }

    /**
     * @param $image
     * @param $dir
     * @param $thumb_values
     * @return string
     * @throws InvalidManipulation
     */
    public function generate_thumb($image, $dir, $thumb_values ): string
    {
        $directory = '/app/' . $dir . '/';
        $w = $thumb_values['width'];
        $h = $thumb_values['height'];

        Image::load(storage_path() . $directory . $image)
            ->width($w)
            ->height($h)
            ->save(storage_path() . $directory . $thumb_values['tn_str'] . $image);

        return $thumb_values['tn_str'] . $image;
    }

    /**
     * @param string $image
     * @param string $dir
     * @param array $thumb_values
     * @return bool
     */
    public function destroyImage(string $image, string $dir, array $thumb_values): bool
    {
        Storage::disk($dir)->delete($image);
        Storage::disk($dir)->delete($thumb_values['tn_str'] . $image);
        return true;
    }
}
