<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\View\View;

class CarouselController extends Controller
{
    public function show(): View
    {
        $carousel = Carousel::where('live', 1)
            ->limit(6)
            ->get();

        $data = ['carousel' => $carousel->shuffle()];
        $data['count'] = count($carousel);

        return view('carousel', ['data' => $data]);
    }
}
