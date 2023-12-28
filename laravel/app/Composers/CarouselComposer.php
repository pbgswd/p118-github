<?php

namespace App\Composers;

use App\Constants\AccessLevelConstants;
use App\Models\Carousel;
use App\Models\Feature;
use App\Models\Options;
use App\Models\Page;
use App\Models\Post;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Void_;

class CarouselComposer
{
    /**
     * @param View $view
     * @return Void
     */
    public function compose(View $view): Void
    {

        $carousel = Carousel::where('live', 1)
            ->orderBy('order')
            ->limit(6)
            ->get();
        $data = ['carousel' => $carousel];
        $data['count'] = count($carousel);

        $view->with('data', $data);
    }
}
