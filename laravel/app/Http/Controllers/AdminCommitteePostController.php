<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCommitteePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return Response
     */
    public function index(CommitteePost $committeePost, Committee $committee)
    {
        $this->authorize('update', $committee);

        $data = [
            'committee' => $committee,
            'posts' => CommitteePost::withoutGlobalScopes()
                ->sortable()
                ->where('committee_id', $committee->id)
                ->orderBy('created_at')
                ->paginate(10),
        ];

        return view('admin.committee_posts_list', ['data' => $data]);
    }

    /**
     * @param Committee $committee
     * @return Factory|View
     */
    public function create(Committee $committee)
    {
        $this->authorize('update', $committee);

        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('admin.committee_post', ['data' => ['post' => $post, 'action' => 'Create']]);
    }

    public function store(StoreCommitteePostRequest $request, Committee $committee, User $user)
    {
        $this->authorize('update', $committee);

        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        Session::flash('success', 'You have saved a new post in '.$committee->name);

        return redirect()->route('admin_committee_post_edit', [$committee->slug, $post->slug]);
    }

    /**
     * @param Committee $committee
     * @param CommitteePost $any_committee_post
     * @return Factory|View
     */
    public function edit(Committee $committee, CommitteePost $any_committee_post)
    {
        $this->authorize('update', $committee);

        $any_committee_post->load('creator', 'committee', 'admin_post_comments');

        $data = [
            'post' => $any_committee_post,
            'action' => 'Edit',
        ];

        return view('admin.committee_post', ['data' => $data]);
    }

    /**
     * @param UpdateCommitteePostRequest $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return RedirectResponse
     */
    public function update(UpdateCommitteePostRequest $request, Committee $committee,
                           CommitteePost $committeePost): RedirectResponse
    {
        $this->authorize('update', $committee);

        $committeePost->fill($request->post);
        $committeePost->save();

        Session::flash('success', 'You have edited the post');

        $committeePost->committee;

        return redirect()->route('admin_committee_post_edit',
            [$committeePost->committee->slug, $committeePost->slug]);
    }

    /**
     * @param DestroyCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(DestroyCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
        $this->authorize('update', $committee);

        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(static function (CommitteePost $post) {
                //todo delete comments associated with a committee post
                $post->delete();
            });

        Session::flash('success', 'Committee '.Str::plural('post', count($request->id)).' deleted.');

        return redirect()->route('committee_posts_list', $committee->slug);
    }
}
