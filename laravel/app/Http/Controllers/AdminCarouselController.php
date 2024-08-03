<?php

namespace App\Http\Controllers;

use App\Http\Requests\Carousel\DestroyCarouselRequest;
use App\Http\Requests\Carousel\StoreCarouselRequest;
use App\Http\Requests\Carousel\UpdateCarouselRequest;
use App\Models\Carousel;
use App\Services\CarouselImageService;
use Illuminate\Support\Facades\Auth;
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

    public function __construct(CarouselImageService $carouselimageservice)
    {
        $this->carouselimageservice = $carouselimageservice;
    }

    /**
     * @return Viewcar
     */
    public function index(): View
    {
        $data = ['carousels' => Carousel::withoutGlobalScopes()->paginate(20)];
        $carousel = new Carousel;
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['count'] = Carousel::withoutGlobalScopes()->count();

        return view('admin.carousel_list', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $carousel = new Carousel;

        $data = ['carousel' => $carousel];
        $data['carousel']['align'] = 'left';
        $data['carousel']['text_color'] = '#FFFFFF';
        $data['carousel']['text_outline_color'] = null;
        $data['folder'] = $carousel->getAttachmentFolder();
        $data['tn_prefix'] = 'tn_';
        $data['filesize'] = '';
        $data['image_data'] = $carousel->getImageData();
        $data['count'] = 0;
        $data['action'] = 'Create';

        return view('admin.carousel', ['data' => $data]);
    }

    /**
     * @param StoreCarouselRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCarouselRequest $request): RedirectResponse
    {
        $carousel = new Carousel($request->carousel);

        $widths = $carousel->getImageWidthSizes();
        $data['folder'] = $carousel->getAttachmentFolder();
        $carousel->user_id = Auth::id();

        if (null !== ($request->file())) {
            $result = $this->carouselimageservice->storeImage($request, false, []);
        }

        foreach ($widths as $w) {
            if (isset($result[$w]['image_'.$w])) {
                $carousel['image_'.$w] = $result[$w]['image_'.$w];
                $carousel['file_'.$w] = $result[$w]['file_'.$w];
            }
        }
        $carousel->live = 0;
        $carousel->save();

        Session::flash('success', 'Carousel Slide saved');

        return redirect()->route('admin_carousel_edit', [$carousel->id]);
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
        $filesize = [];
        $data['action'] = 'Edit';

        $width = [];
        foreach ($data['image_data'] as $w) {
            $width[] = $w['width'];
        }
        $data['count'] = 0;

        foreach ($width as $w) {
            if (!empty($data['carousel']['file_'.$w]) &&
                Storage::disk('carousel')
                    ->exists($data['carousel']['file_' . $w])) {
                $filesize['file_' . $w] =
                    round(Storage::disk('carousel')
                            ->size($data['carousel']['file_' . $w]) / 1024, 2);
                $data['count']++;
            }
        }
        $data['filesize'] = $filesize;

        return view('admin.carousel', ['data' => $data]);
    }

    /**
     * @param UpdateCarouselRequest $request
     * @param Carousel $carousel
     * @return RedirectResponse
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    #[NoReturn]

    public function update(UpdateCarouselRequest $request, Carousel $carousel): RedirectResponse
    {
        $carousel->fill($request->carousel);

        if ($request['unset_outline_color'] == 1) {
            $carousel['text_outline_color'] = null;
        }

        if (! isset($request['carousel']['live'])) {
            $carousel['live'] = 0;
        }

        $data['folder'] = $carousel->getAttachmentFolder();
        $data['image_data'] = $carousel->getImageData();
        $data['tn_prefix'] = 'tn_';

        $result = $this->carouselimageservice->updateImage($request, false, [], $carousel);

        foreach ($result['deleted'] as $d) {
            $carousel['image_'.$d] = '';
            $carousel['file_'.$d] = '';
            $carousel->save();
        }

        if ($result['images'] !== null) {
            $widths = $carousel->getImageWidthSizes();
            foreach ($widths as $w) {
                if (isset($result['images']['image_'.$w])) {
                    $carousel['image_'.$w] = $result['images']['image_'.$w];
                    $carousel['file_'.$w] = $result['images']['file_'.$w];
                }
            }
            Session::flash('success', 'You uploaded '.count($result['images']).' files');
        } else {
            Session::flash('error', 'You have an upload problem');
        }

        $carousel->save();

        Session::flash('success', 'Carousel Slide updated');

        return redirect()->route('admin_carousel_edit', [$carousel->id]);
    }

    /**
     * @param DestroyCarouselRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyCarouselRequest $request): RedirectResponse
    {
        if (! isset($request->id)) {
            Session::flash('warning', 'Nothing deleted.');
        } else {
            $carousel = new Carousel;
            $widths = $carousel->getImageWidthSizes();
            $directory = $carousel->getAttachmentFolder();

            foreach ($request->id as $id) {
                $carousel = Carousel::withoutGlobalScopes()->find($id);

                foreach ($widths as $w) {
                    if (isset($carousel['file_'.$w])) {
                        Storage::disk($directory)->delete($carousel['file_'.$w]);
                    }
                }
                $carousel->delete();
            }
            Session::flash('success', count($request->id).' '.Str::plural('carousel', count($request->id)).' and images deleted.');
        }

        return redirect()->route('admin_carousel_list');
    }
}
