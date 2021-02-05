<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Page;
use App\Models\Post;
use Carbon\Carbon;
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
            $data['birthday'] = 'Happy Birthday IATSE Local 118! You are ' .
                $data['years'] . ' years young today!';
        }

        if (Auth::check()) {
            //$data['news']['posts'] = Topic::find(TopicConstants::NEWS)->front_page_posts;
            // $data['news']['pages'] = Topic::find(TopicConstants::NEWS)->pages;

            $data['news']['posts'] = Post::where([
                ['front_page', 1], ['live', 1]])->get();

            $data['news']['pages'] = Page::where([
                ['front_page', 1], ['live', 1]])->get();

        } else {
            //$data['news']['posts'] = Topic::find(TopicConstants::NEWS)->public_posts;
            //$data['news']['pages'] = Topic::find(TopicConstants::NEWS)->public_pages;

            $data['news']['posts'] = Post::where([
                ['front_page', 1], ['live', 1], ['access_level', AccessLevelConstants::PUBLIC]
            ])->get();

            $data['news']['pages'] = Page::where([
                ['front_page', 1], ['live', 1], ['access_level', AccessLevelConstants::PUBLIC]
            ])->get();
        }

        return view('hello', ['data' => $data]);
    }
}
