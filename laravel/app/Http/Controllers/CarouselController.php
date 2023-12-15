<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param Carousel $carousel
     * @return Response
     */
    public function show(Carousel $carousel): View
    {
        return view('carousel');
    }

}
