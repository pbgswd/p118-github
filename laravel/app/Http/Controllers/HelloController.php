<?php

namespace App\Http\Controllers;

use App\Models\Hello;
use Carbon\Carbon;
use Illuminate\Http\Response;

class HelloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Hello $data)
    {
        $data['foundingYear'] = 1904;
        $today = Carbon::today();
        $data['foundingDate'] = Carbon::createMidnightDate(1904, 9, 13);
        $data['years'] = $data['foundingDate']->diffInYears($today);

        if ($today->isBirthday($data['foundingDate'])) {
            $data['birthday'] = "Happy Birthday IATSE Local 118! You are " . $data['years'] . " years young today!";
        }

//todo datetime - add time zone management to Laravel

        return view('hello', ['data' => $data]);
    }

}
