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
use Illuminate\View\View;

class HelloController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data['foundingYear'] = 1904;
        $today = Carbon::today();
        $data['foundingDate'] = Carbon::createMidnightDate(1904, 9, 13);
        $data['years'] = $data['foundingDate']->diffInYears($today);

        $data['birthday'] = '';
        if ($today->isBirthday($data['foundingDate'])) {
            $data['birthday'] = 'Happy Birthday IATSE Local 118! You are '.
                $data['years'].' years young today!';
        }

        if (Auth::check()) {
            $data['news']['posts'] = Topic::find(TopicConstants::NEWS)->posts;
            $data['news']['pages'] = Topic::find(TopicConstants::NEWS)->pages;
        } else {
            $data['news']['posts'] = Topic::find(TopicConstants::NEWS)->public_posts;
            $data['news']['pages'] = Topic::find(TopicConstants::NEWS)->public_pages;
        }

        return view('hello', ['data' => $data]);
    }
}
