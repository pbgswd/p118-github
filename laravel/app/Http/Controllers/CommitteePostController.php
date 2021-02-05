<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteePost\DestroyCommitteePostRequest;
use App\Http\Requests\CommitteePost\StoreCommitteePostRequest;
use App\Http\Requests\CommitteePost\UpdateCommitteePostRequest;
use App\Models\Committee;
use App\Models\CommitteePost;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommitteePostController extends Controller
{
    /**
     * @param Committee $committee
     * @return View
     * @throws AuthorizationException
     */
    public function create(Committee $committee): View
    {
        $this->authorize('create', [CommitteePost::class, $committee]);

        $post = new CommitteePost;
        $post['committee'] = $committee;

        return view('committee_post_form', [
            'data' => [
                'post' => $post, 'action' => 'Create',
            ],
        ]);
    }

    /**
     * @param StoreCommitteePostRequest $request
     * @param Committee $committee
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreCommitteePostRequest $request, Committee $committee): RedirectResponse
    {
        $this->authorize('create', [CommitteePost::class, $committee]);

        $post = new CommitteePost($request->input('post'));
        $post->committee_id = $committee->id;

        $post->save();

        Session::flash('success', 'You have saved a new post in '.$committee->name);

        return redirect()->route('committee_post_edit_form', [$committee->slug, $post->slug]);
    }

    /**
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Committee $committee, CommitteePost $committeePost): View
    {
        $this->authorize('update', [CommitteePost::class, $committeePost]);

        $committeePost->creator;

        return view('committee_post_form', [$committee->slug, $committeePost->slug], [
            'data' => [
                'post' => $committeePost,
                'action' => 'Edit',
            ],
        ]);
    }

    /**
     * @param UpdateCommitteePostRequest $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return View
     * @throws AuthorizationException
     */
    public function update(UpdateCommitteePostRequest $request,
                           Committee $committee, CommitteePost $committeePost): View
    {
        $this->authorize('update', [CommitteePost::class, $committeePost]);

        $committeePost->fill($request['post']);
        $committeePost->save();
        $committeePost->creator;

        return view('committee_post_form', [
            $committee->slug, $committeePost->slug, ], [
            'data' => ['post' => $committeePost, 'action' => 'Edit'],
        ]);
    }

    /**
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return View
     */
    public function show(Committee $committee, CommitteePost $committeePost): View
    {
        $data = [];
        $data['committeepost'] = $committeePost->loadWithoutGlobalScopes(['creator', 'committee']);
        $user = Auth::user();

        $data['canManage'] = 0;
        if ($user->hasRole('committee') &&
            $user->hasPermissionTo('manage committee') ||
            $user->hasRole('super-admin') ||
            $user->id == $data['committeepost']->user_id
        ) {
            $data['canManage'] = 1;
        }

        /*
        if($data['committeepost']->allow_comments == 1) {
            $data['committeepost']->load('post_comments');
            $data['committeepost']->post_comments = $data['committeepost']
        ->post_comments->sortByDesc('created_at');
        }
        */
        //  $data['action'] = 'Add';

        return view('committee_post', ['data' => $data]);
    }

    /**
     * @param DestroyCommitteePostRequest $request
     * @param Committee $committee
     * @param CommitteePost $committeePost
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyCommitteePostRequest $request,
                            Committee $committee, CommitteePost $committeePost): RedirectResponse
    {
        $this->authorize('delete', [CommitteePost::class, $committeePost]);

        CommitteePost::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (CommitteePost $post) {
                $post->delete();
            });

        Session::flash('success', 'Committee '.
            Str::plural('post', count($request->id)).' deleted.');

        return redirect()->route('committee', $committee->slug);
    }
}
