<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Page\DestroyPageRequest;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\Message;
use App\Models\Options;
use App\Models\Page;
use App\Models\Topic;
use App\Services\AttachmentService;
use App\Services\FeatureService;
use App\Services\MessageService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    private AttachmentService $attachmentService;

    private MessageService $messageService;

    private FeatureService $featureService;

    /**
     * @var AttachmentService
     */
    public function __construct(AttachmentService $attachmentService, MessageService $messageService, FeatureService $featureService)
    {
        $this->attachmentService = $attachmentService;
        $this->messageService = $messageService;
        $this->featureService = $featureService;
    }

    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Page::class);
        $pages = Page::withoutGlobalScopes()
            ->sortable()
            ->with('topics', 'user', 'attachments')
            ->orderBy('updated_at', 'desc')
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
     * @throws AuthorizationException
     */
    public function create(): View
    {
        Gate::authorize('create', Page::class);

        $page = new Page;
        $page['user_id'] = Auth::id();

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
     * @throws AuthorizationException
     */
    public function store(StorePageRequest $request): RedirectResponse
    {
        Gate::authorize('create', Page::class);

        $page = new Page($request->page);

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

        Session::flash('success', 'You have saved a new page');

        return redirect()->route('page_edit', [$page->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Page $page): View
    {
        Gate::authorize('update', Page::class);

        $page->load('user', 'attachments', 'topics');

        $data = [
            'page' => $page,
            'topics' => Topic::all(),
            'existing_message' => Message::where('source_url', env('APP_URL').'/page/'.$page->slug)->exists(),
            'assignedTopics' => $page->topics->pluck('id')->toArray(),
            'access_levels' => Options::access_levels(),
            'action' => 'Edit',
            'model_name' => 'page',
        ];

        return view('admin.page', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdatePageRequest $request, Page $any_page): RedirectResponse
    {
        Gate::authorize('update', Page::class);

        Gate::authorize('update', $any_page);

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
            $any_page->topics()->detach($any_page->topics->pluck('id')->toArray());
        } else {
            $any_page->topics()->sync($request->page['topic_id']);
        }

        Session::flash('success', 'You have edited the page');

        return redirect()->route('page_edit', [$any_page->slug]);
    }

    public function message(Page $page): RedirectResponse
    {
        Gate::authorize('update', Page::class);

        $source_url = env('APP_URL').'/page/'.$page->slug;
        if (Message::where('source_url', $source_url)->exists()) {
            Session::flash('warning', 'A message from this content has already been created');

            return redirect()->route('page_edit', [$page->slug]);
        }

        $page->load('user', 'attachments', 'topics');
        $page->source_url = $source_url;
        $msg = $this->messageService->createPageMessage($page);

        Session::flash('success', 'new message from pages saved');

        return redirect()->route('admin_message_edit', [$msg->id, $msg->slug]);
    }

    public function feature(Page $page): RedirectResponse
    {
        Gate::authorize('update', Page::class);
        $page->source_url = env('APP_URL').'/page/'.$page->slug;
        $msg = $this->featureService->createPageFeature($page);
        Session::flash('success', 'new feature from Pages saved');

        return redirect()->route('admin_feature_edit', [$msg->slug]);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyPageRequest $request): RedirectResponse
    {
        Gate::authorize('delete', Page::class);

        Page::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Page $page) {
                $this->attachmentService->destroyAttachments($page);
                $page->topics()->detach();
                $page->delete();
            });

        Session::flash('success', Str::plural('Page', count([$request->id])).' deleted.');

        return redirect()->route('pages_list');
    }
}
