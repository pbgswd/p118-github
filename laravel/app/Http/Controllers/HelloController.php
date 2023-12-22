<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\View\View;

class HelloController extends Controller
{
    public function __construct(Carousel $carousel)
    {
        //parent::construct();
        //$this->carousel = $carousel;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        /**
        $client = new Predis\Client();
        $client->set('foo', 'bar');
        $value = $client->get('foo');
         **/
        $data =[];
 /*       $carousel = Carousel::where('live', 1)
            ->orderBy('order')
            ->limit(6)
            ->get();

        $data = ['carousel' => $carousel];
        $data['count'] = count($carousel);*/

        return view('hello', ['data' => $data]);
    }
}
