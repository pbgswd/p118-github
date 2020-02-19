<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\DestroyPage;
use App\Http\Requests\Page\StorePage;
use App\Http\Requests\Page\UpdatePage;
use App\Models\Page;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class PageController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        //admin
        $this->authorize('viewAny', Auth::user());
        $pages = Page::sortable()->with('tagged', 'user')->paginate(20);

        return view('admin.listpages', ['data' => array('pages' => $pages)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list(Request $request)
    {
        // public
        if (Auth::check()) {
            $pages = Page::sortable()->with('tagged')->paginate(10);
            //todo group of private pages, public pages
        }
        else {
            $pages = Page::sortable()->where('access_level', '=', 'public')->with('tagged')->paginate(10);
        }

        return view('pages', ['data' => array('pages' => $pages)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $page = new Page;
        $page['user_id'] = Auth::id();
        $page->topics;
        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.page', ['data' => ['page' => $page, 'assignedTopics' => [], 'access_levels' => $access_levels, 'topics' => $topics, 'action' => 'Create']]);
    }

    /**
     * @param StorePage $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePage $request)
    {
        $this->authorize('create', Auth::user());

        $page = new Page($request->input('page'), $request->input('tags'));
        $page->save();

        if (!empty($request->input('page.topic_id'))) {
            $page->topics()->sync($request->input('page.topic_id'));
        }

        if (!empty($request->tags)) {
            $page->tag(trim($request->tags, ','));
        }

        Session::flash('success', "You have saved a new page");

        return redirect()->route('page_edit', [$page->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function show(Page $page)
    {
        // public
        //Todo service to check if user may view content
        $page->load('topics', 'user');

        //todo handle 2 criteria live, and access_level


        $data = ['page' => $page];

        return view('page', ['data' => $data]);
    }

    /**
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Page $page)
    {
        $this->authorize('update', Auth::user());

        $page->user;

        $assignedTopics = [];
        foreach ($page->topics as $topic) {
            $assignedTopics[] = $topic->pivot->topic_id;
        }

        $topics = Topic::all();

        $access_levels = $this->getFormOptions(['access_levels']);

        $data = ['page' => $page, 'topics' => $topics, 'assignedTopics' => $assignedTopics, 'access_levels' => $access_levels, 'action' => 'Edit'];

        return view('admin.page', ['data' => $data]);
    }

    /**
     * @param UpdatePage $request
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePage $request, Page $page)
    {
        $this->authorize('update', Auth::user());

        $user = Auth::user();
        $user->roles;
//todo, page controller needs proper update PagePolicy
        $this->authorize('update', $page);

        $data = $request['page'];

        $page->fill($data);
        $page->save();

        if (empty($data['topic_id'])) {
            $assignedTopics = [];
            foreach ($page->topics as $topic) {
                $assignedTopics[] = $topic->pivot->topic_id;
            }
            $page->topics()->detach($assignedTopics);
        } else {
            $page->topics()->sync($data['topic_id']);
        }

        if (empty($request->tags)) {
            $page->untag();
        } else {
            $page->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the page");

        return redirect()->route('page_edit', [$page->slug]);
    }


    /**
     * @param DestroyPage $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyPage $request)
    {
        $this->authorize('delete', Auth::user());

        $page = Page::find($request->id)->first();

        $page->untag();

        $assignedTopics = [];
        foreach ($page->topics as $topic) {
            $assignedTopics[] = $topic->pivot->topic_id;
        }
        $page->topics()->detach($assignedTopics);

        Page::destroy($request->id);

        Session::flash('success', Str::plural('Page', count($request->id)) . ' deleted.');

        return redirect()->route('pages_list');
    }
}
