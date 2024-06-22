<?php

namespace App\Composers;

use App\Models\Carousel;
use Illuminate\View\View;

class CarouselComposer
{
    public function compose(View $view): void
    {

        $carousel = Carousel::where('live', 1)
            ->limit(6)
            ->get();
        $data = ['carousel' => $carousel];
        $data['count'] = count($carousel);

        $view->with('data', $data);
    }
}
