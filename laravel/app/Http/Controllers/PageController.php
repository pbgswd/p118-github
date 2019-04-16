<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\DestroyPage;
use App\Http\Requests\Page\StorePage;
use App\Http\Requests\Page\UpdatePage;
use App\Models\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pages = Page::sortable()->with('tagged')->paginate(20);

        return view('admin.listpages', ['data'=>array('pages'=>$pages )]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $pages = Page::sortable()->with('tagged')->paginate(10);

        return view('pages', ['data'=>array('pages'=>$pages )]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = new Page;

        return view('admin.page', ['data' => ['page' => $page, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePage $request)
    {
        $page = new Page($request->input('page'), $request->input('tags'));

        $page->image = $this->uploadImage($request);

        $page->save();

        if (!empty($request->tags)) {
            $page->tag(trim($request->tags, ','));
        }

        Session::flash('success', "You have saved a new page");

        return redirect()->route('page_edit', [$page->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        // public
        $data = ['page'=>$page, 'action'=>'Edit'];

        return view('page', ['data'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $data = ['page'=>$page, 'action'=>'Edit'];

        return view('admin.page', ['data'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePage $request, Page $page)
    {
        $data = $request['page'];

        $data['image'] = $this->uploadImage($request);

        if (isset( $request['page']['delete_image']))
        {
            Storage::disk('public')->delete( $request->page['image'] );
            Session::flash('info', "You have deleted " . $data['image']);
            $data['image'] = NULL;
        }

        $page->fill($data);
        $page->save();

        if (empty($request->tags))
        {
            $page->untag();
        }
        else
        {
            $page->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the page");

        return redirect()->route('page_edit', [$page->slug]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPage $request)
    {
        $page = Page::find($request->id)->first();

        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->untag();

        Page::destroy($request->id);

        Session::flash('success', Str::plural('Page', count($request->id)) . ' deleted.');

        return redirect()->route('pages_list');
    }

    protected function uploadImage(FormRequest $request)
    {
        if (!$request->image) {
            return null;
        }

        $imageName = $request->image->getClientOriginalName();

        if (!$request->image->storeAs('public', $imageName)) {
            Session::flash('warning', "Did not store " . $imageName);

            return null;
        }

        return $imageName;
    }
}
