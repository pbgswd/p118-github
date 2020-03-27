<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(): Response
    {
        // public
        if (Auth::check()) {
            $pages = Page::sortable()->with('tagged')->paginate(10);
        }
        else {
            $pages = Page::sortable()->where('access_level', '=', AccessLevelConstants::PUBLIC)->with('tagged')->paginate(10);
        }

        return view('pages', ['data' => ['pages' => $pages]]);
    }

    /**
     * Display the specified resource.
     * @param Page $page
     *
     * @return Response
     */
    public function show(Page $page): Response
    {
        $page->load('topics', 'user', 'attachments');

        //todo handle 2 criteria live, and access_level another scope

        $data = ['page' => $page];

        return view('page', ['data' => $data]);
    }
}
