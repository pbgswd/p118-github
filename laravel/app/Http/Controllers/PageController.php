<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Page;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PageController extends Controller
{
    public function list(): View
    {
        if (Auth::check()) {
            $pages = Page::where('live', 1)
                ->with('topics')
                ->paginate(9);
        } else {
            $pages = Page::where([['access_level', '=', AccessLevelConstants::PUBLIC], ['live', 1]])
                ->with('topics')
                ->paginate(9);
        }

        return view('pages', ['data' => ['pages' => $pages]]);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Page $page): Response
    {
        //todo public page policy if not public page?
        //$this->authorize('view', Page::class);

        if (Auth::check() === false && $page->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this page.');

            return redirect('login');
        }

        $page->load('topics', 'user', 'attachments');

        return view('page', ['data' => ['page' => $page]]);
    }
}
