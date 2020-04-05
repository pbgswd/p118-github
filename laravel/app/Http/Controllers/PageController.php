<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        if (Auth::check()) {
            $pages = Page::sortable()->with('tagged')->paginate(10);
        }
        else {
            $pages = Page::sortable()->where('access_level', '=', AccessLevelConstants::PUBLIC)->with('tagged')->paginate(10);
        }

        return view('pages', ['data' => ['pages' => $pages]]);
    }

    /**
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Page $page)
    {
        $page->load('topics', 'user', 'attachments');

        return view('page', ['data' =>  ['page' => $page]]);
    }
}
