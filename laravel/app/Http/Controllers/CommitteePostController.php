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

class CommitteePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Committee $committee
     * @param User $user
     * @return Response
     */
    public function store(StoreCommitteePostRequest $request, Committee $committee, User $user)
    {
        //$this->authorize('create', Auth::user());
        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;
        $post->user_id = Auth::id();

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('committee_post', [$committee->slug, $post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @param CommitteePostComment $committeePostComments
     * @return Response
     * public
     */
    public function show(Committee $committee, CommitteePost $committeePost, CommitteePostComment $committeePostComments)
    {
        // $this->authorize('create', Auth::user());

        $data =[];
        $data['committeepost'] = $committeePost->loadWithoutGlobalScopes(['creator', 'committee' , 'post_comments']);
        $data['committeepost']->post_comments = $data['committeepost']->post_comments->sortByDesc('created_at');
        $data['action'] = 'Add';


        return view('committee_post', ['data' => $data]);
    }


    /**
     * @param UpdateCommitteePostRequest $request
     * @param $post
     * @param CommitteePost $any_committee_post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCommitteePostRequest $request, $post, CommitteePost $any_committee_post)
    {
        // $this->authorize('update', Auth::user());
        $data = $request['post'];

        $any_committee_post->fill($data);
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
