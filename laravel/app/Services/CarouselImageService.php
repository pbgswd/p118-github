<?php

namespace App\Services;

use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class CarouselImageService
{
    public function storeImage($request, bool $make_thumb, array $thumb_values): array
    {
        $carousel = new Carousel;
        $directory = $carousel->getAttachmentFolder();
        $widths = $carousel->getImageWidthSizes();

        $result = [];

        foreach ($widths as $w) {
            if ($request->file('file.image_'.$w) !== null) {

                $img = $request->file('file.image_'.$w)->store('', $directory);

                /*
                ImageOptimizer::optimize(storage_path().$directory.$image);
                if ($make_thumb) {
                    $result = $this->generate_thumb($image, $dir, $thumb_values);
                }
                */
                $result[$w]['file_'.$w] = $img;
                $result[$w]['image_'.$w] = $request->file['image_'.$w]->getClientOriginalName();
            }
        }

        return $result;
    }

    /**
     * @param  string  $dir
     *
     * @throws InvalidManipulation
     */
    public function updateImage($request, bool $make_thumb, array $thumb_values): array
    {
        $car = new Carousel;
        $directory = $car->getAttachmentFolder();
        $widths = $car->getImageWidthSizes();

        $carousel['deleted'] = [];
        $carousel['images'] = [];

        foreach ($widths as $w) {

            // delete
            if ($request['delete_image_'.$w] !== null) {
                Storage::disk($directory)->delete($request['carousel']['file_'.$w]);
                $carousel['deleted'][] = $w;
            }

            // upload
            if ($request->file('file.image_'.$w) !== null) {
                $carousel['images']['file_'.$w] = $request->file('file.image_'.$w)->store('', $directory);
                $carousel['images']['image_'.$w] = $request['file']['image_'.$w]->getClientOriginalName();
            }

        }

        // ImageOptimizer::optimize(storage_path().$directory.$image);
        /* if ($make_thumb) {
             $result = $this->generate_thumb($image, $directory, $thumb_values);
         }*/
        return $carousel;

    }

    /**
     * @param  $dir
     *
     * @throws InvalidManipulation
     */
    public function generate_thumb($image, $thumb_values): string
    {
        $carousel = new Carousel;
        $directory = $carousel->getAttachmentFolder();

        $w = $thumb_values['width'];
        $h = $thumb_values['height'];

        Image::load(storage_path().$directory.$image)
            ->width($w)
            ->height($h)
            ->save(storage_path().$directory.$thumb_values['tn_str'].$image);

        return $thumb_values['tn_str'].$image;
    }

    public function destroyImage(string $image, array $thumb_values): bool
    {
        $carousel = new Carousel;
        $directory = $carousel->getAttachmentFolder();

        Storage::disk($directory)->delete($image);
        //  Storage::disk($directory)->delete($thumb_values['tn_str'].$image);

        return true;
    }
}
