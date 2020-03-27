<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\AttachmentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    /**
     * @var AttachmentService
     */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        // public
        if (Auth::check()) {
            $pages = Page::sortable()->with('tagged')->paginate(10);
        }
        else {
            $pages = Page::sortable()->where('access_level', '=', 'public')->with('tagged')->paginate(10);
        }

        return view('pages', ['data' => array('pages' => $pages)]);
    }

    /**
     * Display the specified resource.
     * @param Page $page
     * @return Response
     */
    public function show(Page $page)
    {
        $page->load('topics', 'user', 'attachments');

        //todo handle 2 criteria live, and access_level another scope

        $data = ['page' => $page];

        return view('page', ['data' => $data]);
    }

}
