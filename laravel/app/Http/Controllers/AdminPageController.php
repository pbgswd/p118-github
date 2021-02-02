<?php

namespace App\Http\Controllers;

use App\Http\Requests\Page\DestroyPageRequest;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Options;
use App\Models\Page;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

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
     * @return View
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Page::class);
        $pages = Page::withoutGlobalScopes()
            ->sortable()
            ->with('topics', 'tagged', 'user')
            ->paginate(20);
        $count = Page::withoutGlobalScopes()->count();

        return view(
            'admin.listpages',
            [
                'data' => [
                    'pages' => $pages,
                    'count' => $count,
                ],
            ]
        );
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Page::class);

        $page = new Page;
        $page['user_id'] = Auth::id();
        $page->topics;

        return view(
            'admin.page',
            [
                'data' => [
                    'page' => $page,
                    'assignedTopics' => [],
                    'access_levels' => Options::access_levels(),
                    'topics' => Topic::all(),
                    'action' => 'Create',
                    'model_name' => 'page',
                ],
            ]
        );
    }

    /**
     * @param StorePageRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StorePageRequest $request): RedirectResponse
    {
        $this->authorize('create', Page::class);

        $page = new Page($request->page, $request->input('tags'));

        $page->save();

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $page);

            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        if (! empty($request->input('page.topic_id'))) {
            $page->topics()->sync($request->input('page.topic_id'));
        }

        if (! empty($request->tags)) {
            $page->tag(trim($request->tags, ','));
        }

        Session::flash('success', 'You have saved a new page');

        return redirect()->route('page_edit', [$page->slug]);
    }

    /**
     * @param Page $page
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Page $page): View
    {
        $this->authorize('update', Page::class);

        $page->load('user', 'attachments', 'topics');

        $data = [
            'page' => $page,
            'topics' => Topic::all(),
            'assignedTopics' => $page->topics->pluck('id')->toArray(),
            'access_levels' => Options::access_levels(),
            'action' => 'Edit',
            'model_name' => 'page',
        ];

        return view('admin.page', ['data' => $data]);
    }

    /**
     * @param UpdatePageRequest $request
     * @param Page $any_page
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdatePageRequest $request, Page $any_page): RedirectResponse
    {
        $this->authorize('update', Page::class);

        $user = Auth::user();
        $user->roles;

        $this->authorize('update', $any_page);

        $any_page->fill($request->page);
        $any_page->save();

        $result = $this->attachmentService->updateAttachment($request, $any_page);

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $any_page);
            if ($result) {
                Session::flash('success', 'You uploaded '.
                    count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        if (empty($request->input('page.topic_id'))) {
            $assignedTopics = [];
            foreach ($request->input('page.topics') as $topic) {
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

        Session::flash('success', 'You have edited the page');

        return redirect()->route('page_edit', [$any_page->slug]);
    }

    /**
     * @param DestroyPageRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyPageRequest $request): RedirectResponse
    {
        $this->authorize('delete', Page::class);

        Page::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Page $page) {
                $page->untag();
                $this->attachmentService->destroyAttachments($page);
                $page->topics()->detach();
                $page->delete();
            });

        Session::flash('success', Str::plural('Page', count($request->id)).' deleted.');

        return redirect()->route('pages_list');
    }
}
