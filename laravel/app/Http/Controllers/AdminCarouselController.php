<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Services\CarouselImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
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

       // dd($request->all());

         $result = $this->carouselimageservice->updateImage($request, false, [], $carousel);


         //new files
          if (null !== ($request->file('carousel'))) {
            $result = $this->carouselimageservice->storeImage($request, $carousel);
              if ($result) {
                Session::flash('success', 'You uploaded '
              .count($request->file('attachments')).' files');
              } else {
                Session::flash('error', 'You have an upload problem');
              }
          }
dd($result);
    //todo add file name assets to $carousel before save();

        $carousel->save();

        Session::flash('success', 'Carousel Slide updated');
        return redirect()->route('admin_carousel_edit', [$carousel->id]);
    }

    /**
     * @param Carousel $carousel
     * @return RedirectResponse
     */
    public function destroy(Carousel $carousel): RedirectResponse
    {
        //todo delete 4 files
        //todo delete data row for carousel
        Session::flash('success', 'Carousel Slide deleted');
        return redirect()->route('admin_carousel_list');
    }
}
