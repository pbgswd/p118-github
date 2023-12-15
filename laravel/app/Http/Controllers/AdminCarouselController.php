<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
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
        $data = [];
        $carousel = new Carousel;
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();

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
        $carousel = new Carousel($request);

        $widths = $carousel->getImageWidthSizes();

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
        $data =[];
        $data['action'] = "Edit";
       // dd(__METHOD__);
        return view('admin_carousel_edit', ['data' => $data]);
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

        return redirect()->route('admin_carousel_list');
    }
}
