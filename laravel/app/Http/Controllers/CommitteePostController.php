<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommitteePostController extends Controller
{

    /**
     * @param Committee $committee
     * @return Factory|View
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
     * @param StoreCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function store(StoreCommitteePostRequest $request, Committee $committee)
    {
        //$this->authorize('create', Auth::user());
        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;

        $post->save();

        Session::flash('success', "You have saved a new post in " . $committee->name);

        return redirect()->route('committee_post_edit_form', [$committee->slug, $post->slug]);
    }

    /**
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return Application|Factory|View
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
     * @return Application|Factory|View
     */
    public function update(UpdateCommitteePostRequest $request,
                           Committee $committee, CommitteePost $committeePost)
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
    public function show(Committee $committee, CommitteePost $committeePost,
                         CommitteePostComment $committeePostComments)
    {
        // $this->authorize('create', Auth::user());

        $data =[];
        $data['committeepost'] = $committeePost->loadWithoutGlobalScopes(['creator', 'committee']);

        /*
        if($data['committeepost']->allow_comments == 1) {
            $data['committeepost']->load('post_comments');
            $data['committeepost']->post_comments = $data['committeepost']
        ->post_comments->sortByDesc('created_at');
        }
        */

        $data['action'] = 'Add';

        return view('committee_post', ['data' => $data]);
    }


    /**
     * @param DestroyCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteePostRequest $request,
                            Committee $committee): RedirectResponse
    {
        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (CommitteePost $post) {
                $post->delete();
            });

        Session::flash('success', 'Committee ' .
            Str::plural('post', count($request->id)) . ' deleted.');

        return redirect()->route('committee', $committee->slug);
    }
}
