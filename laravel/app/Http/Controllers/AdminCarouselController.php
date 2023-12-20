<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Services\CarouselImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminCarouselController extends Controller
{
    /**
     * @var CarouselImageService
     */
    private $carouselimageservice;

    /**
     * @param CarouselImageService $carouselimageservice
     */
    public function __construct(CarouselImageService $carouselimageservice)
    {
        $this->carouselimageservice = $carouselimageservice;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $data = ['carousels' => Carousel::paginate(20)];
        $carousel = new Carousel;
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['count'] = count($carousel->all());

        return view('admin.carousel_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $carousel = new Carousel;

        $data = ['carousel' => ''];
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['tn_prefix'] = 'tn_';
        $data['filesize'] = '';
        $data['image_data'] = $carousel->getImageData();
        $data['action'] = "Create";

        return view('admin.carousel', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $carousel = new Carousel($request->id);

        $widths = $carousel->getImageWidthSizes();

//todo upload images
//todo generate thumbs
//todo populate array to store data

        if (null !== ($request->file('attasdf'))) {
            $result = $this->carouselimageservice->createAttachment($request, $carousel);

            if ($result) {
                Session::flash('success', 'You uploaded '
                    .count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }


        $carousel->save();


        Session::flash('success', 'Carousel Slide saved');
        return redirect()->route('admin_carousel_edit', [$carousel->id]);

    }

    /**
     * @param Carousel $carousel
     * @return void
     */
    public function show(Carousel $carousel)
    {

    }

    /**
     * @param Carousel $carousel
     * @return View
     */
    public function edit(Carousel $carousel): View
    {
        $carousel->load('user');
        $data = ['carousel' => $carousel];
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['tn_prefix'] = 'tn_';
        $data['filesize'] = '';
        $data['action'] = "Edit";

        // todo get actual file size of each image for data
       //todo do count of images in the row returned to determine if all images are present for msg in view

        //get an array out of the 'width' element of the data
        foreach($data['image_data'] as $w)
        {
            $width[] = $w['width'];
        }
        $count = 0;

        // use the width array above to iterate through $data['carousel'] to count how many files there are
        foreach($width as $w)
        {
            if(trim($data['carousel']['file_'.$w]) != '')
            {
                $count++;
            }
        }

        $data['count'] = $count;

        return view('admin.carousel', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @param Carousel $carousel
     * @return RedirectResponse
     */
    #[NoReturn] public function update(Request $request, Carousel $carousel): RedirectResponse
    {

       //todo delete any current files with changes
        //todo save changes

        //todo upload images
//todo generate thumbs
//todo populate array to store data

        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['tn_prefix'] = 'tn_';

         $result = $this->carouselimageservice->updateImage($request, false, [], $carousel);

         //delete data
         foreach($result['deleted'] as $d)
         {
             $carousel['image_' . $d] = '';
             $carousel['file_' . $d] = '';
             $carousel->save();
         }

        if (null !== $result['images']) {
            $widths = $carousel->getImageWidthSizes();

            foreach($widths as $w)
            {
                if(isset( $result['images']['image_' . $w ])) {
                    $carousel['image_'. $w] = $result['images']['image_' . $w ];
                    $carousel['file_'. $w] = $result['images']['file_' . $w ];
                }
            }


            Session::flash('success', 'You uploaded '. count($result['images']) . ' files');
        } else {
            Session::flash('error', 'You have an upload problem');
        }
        $carousel->save();

        Session::flash('success', 'Carousel Slide updated');
        return redirect()->route('admin_carousel_edit', [$carousel->id]);
    }

    /**
     * @param Carousel $carousel
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {

        if(!isset($request->ids)) {
            Session::flash('warning', 'Nothing deleted.');
        }
        else
        {
            //todo specify which image I want to delete
            $carousel = new Carousel;
            $widths = $carousel->getImageWidthSizes();
            $directory = $carousel->getAttachmentFolder();
            $carousels = Carousel::find($request->ids);

            foreach($carousels as $carousel)
            {
                foreach($widths as $w)
                {
                    Storage::disk($directory)->delete( $carousel['file_' . $w] );
                }
                $carousel->delete();
            }


 /*           $carousels = Carousel::find($request->ids)
                ->each(function (Carousel $car) {
                    dd($car);
                    $this->carouselimageservice->destroyImage($car,[]);
                    $car->delete();
                });*/
            Session::flash('success', Str::plural('carousel', count([$carousels])) . ' and images deleted.');
        }

        return redirect()->route('admin_carousel_list');
    }
}
