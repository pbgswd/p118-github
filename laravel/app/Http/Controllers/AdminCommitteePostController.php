<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        // $this->authorize('list', Auth::user());
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Committee $committee)
    {
        //todo enable permission

        // $this->authorize('create', Auth::user());
        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('admin.committee_post', ['data' => ['post' => $post, 'action' => 'Create',]]);
    }


    public function store(StoreCommitteePostRequest $request, Committee $committee, User $user)
    {
        //$this->authorize('create', Auth::user());
        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('admin_committee_post_edit', [$committee->slug, $post->slug]);
    }


    /**
     * @param Committee $committee
     * @param CommitteePost $any_committee_post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Committee $committee, CommitteePost $any_committee_post)
    {
        // $this->authorize('update', Auth::user());
//todo doesnt load a post comment if it is not live
        $any_committee_post->load('creator', 'committee' , 'admin_post_comments');

        $data = [
            'post' => $any_committee_post,
            'action' => 'Edit',
        ];

        return view('admin.committee_post', ['data' => $data]);
    }

    /**
     * @param UpdateCommitteePostRequest $request
     * @param CommitteePost $any_committee_post
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(UpdateCommitteePostRequest $request, Committee $committee, CommitteePost $committeePost): RedirectResponse
    {
        // $this->authorize('update', Auth::user());

        $committeePost->fill($request->post);
        $committeePost->save();

        Session::flash('success', "You have edited the post");

        $committeePost->committee;

        return redirect()->route('committee_post_edit', [$committeePost->committee->slug, $committeePost->slug]);
    }

    /**
     * @param DestroyCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(static function (CommitteePost $post) {
                //todo delete comments associated with a committee post
                $post->delete();
            });

        Session::flash('success', 'Committee ' . Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('committee_posts_list', $committee->slug);
    }
}
