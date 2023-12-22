<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\View\View;

class CarouselController extends Controller
{

    /**
     * @return View
     */
    public function show(): View
    {
        $carousel = Carousel::where('live', 1)
            ->orderBy('order')
            ->limit(6)
            ->get();
        $data = ['carousel' => $carousel];
        $data['count'] = count($carousel);

        return view('carousel', ['data' => $data]);
    }
}
