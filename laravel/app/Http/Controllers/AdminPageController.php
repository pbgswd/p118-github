<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\DestroyPageRequest;
use App\Http\Requests\Page\StorePage;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Page;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


class AdminPageController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Auth::user());
        $pages = Page::withoutGlobalScopes()->sortable()->with('tagged', 'user')->paginate(20);
        $count = Page::withoutGlobalScopes()->count();

        return view('admin.listpages', ['data' => ['pages' => $pages, 'count' => $count]]);
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
        $page->user_id = Auth::id();
        $page->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $page);

            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

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
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Page $page)
    {
        $this->authorize('update', Auth::user());

        $page->load('user', 'attachments', 'topics');

        $data = [
            'page' => $page,
            'topics' => Topic::all(),
            'assignedTopics' => $page->topics->pluck('id')->toArray(),
            'access_levels' => $this->getFormOptions(['access_levels']),
            'action' => 'Edit',
        ];

        return view('admin.page', ['data' => $data]);
    }

    /**
     * @param UpdatePageRequest $request
     * @param Page $any_page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePageRequest $request, Page $any_page): RedirectResponse
    {
        $this->authorize('update', Auth::user());

        $user = Auth::user();
        $user->roles;

        $this->authorize('update', $any_page);

        $any_page->fill($request->page);
        $any_page->save();

        $result = $this->attachmentService->updateAttachment($request, $any_page);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_page);
            if($result) {
                Session::flash('success', "You uploaded " . count($request->file('attachments')) . " files");
            }
            else
            {
                Session::flash('error', "You have an upload problem");
            }
        }

        if (empty($request->page['topic_id'])) {
            $assignedTopics = [];
            foreach ($request->page['topics'] as $topic)
            {
                $assignedTopics[] = $topic->pivot->topic_id;
            }
            $any_page->topics()->detach($assignedTopics);
        } else {
            $any_page->topics()->sync($request->page['topic_id']);
        }

        //todo make tags a service
        if (empty($request->tags)) {
            $any_page->untag();
        } else {
            $any_page->retag(trim($request->tags, ','));
        }

        Session::flash('success', "You have edited the page");

        return redirect()->route('page_edit', [$any_page->slug]);
    }

    /**
     * @param DestroyPageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyPageRequest $request)
    {
        $this->authorize('delete', Auth::user());

        Page::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Page $page) {
                $page->untag();
                $this->attachmentService->destroyAttachments($page);
                $page->topics()->detach();
                $page->delete();
            });

        Session::flash('success', Str::plural('Page', count($request->id)) . ' deleted.');

        return redirect()->route('pages_list');
    }
}
