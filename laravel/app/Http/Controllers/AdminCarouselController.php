<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AdminCarouselController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    /**
     * BylawController constructor.
     *
     * @param AttachmentService $attachmentService
     */
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
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

        // use the width array above to iterate through $data['caoursel'] to count how many files there are
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
    public function update(Request $request, Carousel $carousel): RedirectResponse
    {
       //todo delete any current files with changes
        //todo save changes

        //todo upload images
//todo generate thumbs
//todo populate array to store data

        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['tn_prefix'] = 'tn_';

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
