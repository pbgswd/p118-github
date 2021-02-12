<?php


namespace App\Services;

use App\Models\Options;
use Spatie\Image\Image;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class UserImageService
{
    public function storeImage($request, $dir): array
    {
        //todo handle upload and thumb generation
        $directory = '/app/' . $dir . '/';

        if (null !== $request->file('image')) {

            $image = $request->file('image')->store('', $dir);

            ImageOptimizer::optimize(storage_path() . $directory . $image);

            $w = Options::thumb_values()['width'];
            $h = Options::thumb_values()['height'];

            Image::load(storage_path() . $directory . $image)
                ->width($w)
                ->height($h)
                ->save(storage_path() . $directory . Options::thumb_values()['tn_str'] . $image);
        }

        $file_name = $request->image->getClientOriginalName();


        //todo handle thumb generation, kill bad sized thumbs
        //read directory
        //iterate
        // if any file that starts with tn....... ! =  tn_str
        //delete it
        //create them

        $arr = [
            'image' => $image,
            'file_name' => $file_name,
            'thumb' =>  Options::thumb_values()['tn_str'] . $image,
        ];

        return $arr;
    }

    public function updateImage($request, $dir): array
    {

        $directory = '/app/' . $dir . '/';

        if (null !== $request->file('image')) {

            $image = $request->file('image')->store('', $dir);

            ImageOptimizer::optimize(storage_path() . $directory . $image);

            $w = Options::thumb_values()['width'];
            $h = Options::thumb_values()['height'];

            Image::load(storage_path() . $directory . $image)
                ->width($w)
                ->height($h)
                ->save(storage_path() . $directory . Options::thumb_values()['tn_str'] . $image);
        }

        $file_name = $request->image->getClientOriginalName();


        //todo handle thumb generation, kill bad sized thumbs
        //read directory
        //iterate
        // if any file that starts with tn....... ! =  tn_str
        //delete it
        //create them

        $arr = [
            'image' => $image,
            'file_name' => $file_name,
            'thumb' =>  Options::thumb_values()['tn_str'] . $image,
        ];

        return $arr;
    }

    public function destroyImage()
    {
        //todo delete image, thumbs
    }
}
