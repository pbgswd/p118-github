<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $data = [];
        $data['committee'] = $committee;
        $data['posts'] = CommitteePost::withoutGlobalScopes()
            ->sortable()
            ->where('committee_id', '=', $committee->id)
            ->orderBy('created_at')
            ->paginate(10);

        return view('admin.committee_posts_list', ['data' => ['data' => $data]]);
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

        return redirect()->route('admin.committee_post', [$committee->slug, $post->slug]);
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

        $data['post'] = $any_committee_post;
        $data['action'] = 'Edit';

        return view('admin.committee_post', ['data' => $data]);
    }

    /**
     * @param UpdateCommitteePostRequest $request
     * @param CommitteePost $any_committee_post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCommitteePostRequest $request, $committee_slug, CommitteePost $any_committee_post): RedirectResponse
    {
        // $this->authorize('update', Auth::user());

        $any_committee_post->fill($request->input('post'));
        $any_committee_post->save();

        Session::flash('success', "You have edited the post");

        $any_committee_post->committee;

        return redirect()->route('committee_post_edit', [$any_committee_post->committee->slug, $any_committee_post->slug]);
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
            ->each(function (CommitteePost $post) {
                //todo delete comments associated with a committee post
                $post->delete();
            });

        Session::flash('success', 'Committee ' . Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('committee_posts_list', $committee->slug);
    }
}
