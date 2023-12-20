<?php

namespace App\Services;

use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class CarouselImageService
{
    public function storeImage($request, string $dir, bool $make_thumb, array $thumb_values): array
    {
        $directory = '/app/'.$dir.'/';
        $image = '';

        if (null !== $request->file('image')) {
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
    public function updateImage($request, bool $make_thumb, array $thumb_values): array
    {
        $car = new Carousel;
        $directory = $car->getAttachmentFolder();
        $widths = $car->getImageWidthSizes();

        $carousel['deleted'] = [];
        $carousel['images'] = [];

        foreach($widths as $w) {

            //delete
            if (null !== $request['delete_image_' . $w]) {
                Storage::disk($directory)->delete( $request['carousel']['file_' . $w] );
                $carousel['deleted'][] = $w;
            }

            //upload
            if (null !== $request->file('image_' . $w)) {
                $carousel['images']['file_' . $w] = $request->file('image_' . $w)->store('', $directory);
                $carousel['images']['image_' . $w] = $request['image_'. $w]->getClientOriginalName();
            }

        }

            //ImageOptimizer::optimize(storage_path().$directory.$image);
           /* if ($make_thumb) {
                $result = $this->generate_thumb($image, $directory, $thumb_values);
            }*/
        return $carousel;

    }

    /**
     * @param $image
     * @param $dir
     * @param $thumb_values
     * @return string
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

    /**
     * @param string $image
     * @param array $thumb_values
     * @return bool
     */
    public function destroyImage(string $image,  array $thumb_values): bool
    {
        $carousel = new Carousel;
        $directory = $carousel->getAttachmentFolder();

      //  dd($image->);

        //Storage::disk($directory)->delete( $request['carousel']['file_' . $w] );
        Storage::disk($directory)->delete($image);
      //  Storage::disk($directory)->delete($thumb_values['tn_str'].$image);

        return true;
    }
}
