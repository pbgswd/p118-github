<?php

namespace App\Http\Controllers;

use App\Constants\TopicConstants;
use App\Models\Hello;
use App\Models\Topic;
use App\Services\AllNewsContentService;
use App\Services\PublicNewsContentService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class HelloController extends Controller
{
    /**
     * Display a listing of the resource.
     * FRONT PAGE INDEX OF WEBSITE
     * @return Response
     */
    public function index()
    {
        $data['foundingYear'] = 1904;
        $today = Carbon::today();
        $data['foundingDate'] = Carbon::createMidnightDate(1904, 9, 13);
        $data['years'] = $data['foundingDate']->diffInYears($today);

        $data['birthday'] = '';
        if ($today->isBirthday($data['foundingDate'])) {
            $data['birthday'] = "Happy Birthday IATSE Local 118! You are " .
                $data['years'] . " years young today!";
        }

        if (Auth::check()) {
            $data['news']['posts'] = Topic::find(TopicConstants::NEWS)->posts;
            $data['news']['pages'] = Topic::find(TopicConstants::NEWS)->pages;
        } else {
            $data['news']['posts'] = Topic::find(TopicConstants::NEWS)->public_posts;
            $data['news']['pages'] = Topic::find(TopicConstants::NEWS)->public_pages;
        }

//todo datetime - add time zone management

        return view('hello', ['data' => $data]);
    }

}
