<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * @return View
     */
    public function list(): View
    {
        if (Auth::check()) {
            $pages = Page::sortable()->with('topics','tagged')->paginate(10);
        } else {
            $pages = Page::sortable()
                ->where('access_level', '=', AccessLevelConstants::PUBLIC)
                ->with('topics','tagged')
                ->paginate(10);
        }

        return view('pages', ['data' => ['pages' => $pages]]);
    }

    /**
     * @param Page $page
     * @return View
     */
    public function show(Page $page): View
    {
        if (false === Auth::check() && $page->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this page.');

            return redirect('login');
        }

        $page->load('topics', 'user', 'attachments');

        return view('page', ['data' =>  ['page' => $page]]);
    }
}
