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
     * @param Committee $committee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Committee $committee)
    {
        // $this->authorize('create', Auth::user());
        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('committee_post_form', [
            'data' => [
                'post' => $post, 'action' => 'Create'
            ]
        ]);
    }

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
        //todo pass in committee_id from form request
        $post->committee_id = $committee->id;

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('committee_post_edit_form', [$committee->slug, $post->slug]);
    }

    /**
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Committee $committee, CommitteePost $committeePost)
    {
        $committeePost->creator;
        return view('committee_post_form', [$committee->slug, $committeePost->slug], [
            'data' => [
                'post' => $committeePost,
                'action' => 'Edit',
            ]
        ]);
    }

    /**
     * @param UpdateCommitteePostRequest $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(UpdateCommitteePostRequest $request, Committee $committee, CommitteePost $committeePost)
    {

        $committeePost->fill($request['post']);
        $committeePost->save();
        $committeePost->creator;
        return view('committee_post_form', [
            $committee->slug, $committeePost->slug], [
            'data' => ['post' => $committeePost, 'action' => 'Edit']
        ]);
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
//todo allow comments filter on committee post
        $data =[];
        $data['committeepost'] = $committeePost->loadWithoutGlobalScopes(['creator', 'committee' , 'post_comments']);
        $data['committeepost']->post_comments = $data['committeepost']->post_comments->sortByDesc('created_at');
        $data['action'] = 'Add';

        return view('committee_post', ['data' => $data]);
    }


    /**
     * @param DestroyCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
     //todo if post has comments, it cannot be deleted
     //todo archive when it has comments

        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (CommitteePost $post) {
                //todo delete comments associated with a committee post
                $post->delete();
            });

        Session::flash('success', 'Committee ' . Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('committee', $committee->slug);
    }
}
