<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\DestroyPage;
use App\Http\Requests\Page\StorePage;
use App\Http\Requests\Page\UpdatePage;
use App\Models\Page;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
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
        if (Auth::check()) {
            $pages = Page::sortable()->with('tagged')->paginate(10);
        }
        else {
            $pages = Page::sortable()->where('access_level', '=', 'public')->with('tagged')->paginate(10);
        }

        return view('pages', ['data' => array('pages' => $pages)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page = new Page;
        $page['user_id'] = Auth::id();
        $page->topics;
        $topics = Topic::all();
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.page', ['data' => ['page' => $page, 'assignedTopics' => [], 'access_levels' => $access_levels, 'topics' => $topics, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StorePage $request)
    {
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
        //Todo service to check if user may view content
        $page->load('topics', 'user');

        //todo handle 2 criteria live, and access_level


        $data = ['page' => $page];

        return view('page', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function edit(Page $page)
    {
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Page $page
     * @return Response
     */
    public function update(UpdatePage $request, Page $page)
    {
        //todo, page controller needs proper update PagePolicy
        $user = Auth::user();
        $user->roles;

        $this->authorize('update', $page);

        if ($user->can('update', $page)) {
            echo "can update";
        }

        if ($gate = Gate::allows('edit articles', $page)) {
            //dd($gate);
             //echo 'Allowed';
        } else {
            abort(403);
        }
        dd(__METHOD__);
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
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return Response
     */
    public function destroy(DestroyPage $request)
    {
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
