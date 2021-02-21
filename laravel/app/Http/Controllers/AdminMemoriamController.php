<?php

namespace App\Http\Controllers;

use App\Http\Requests\Memoriam\DestroyMemoriamRequest;
use App\Http\Requests\Memoriam\StoreMemoriamRequest;
use App\Http\Requests\Memoriam\UpdateMemoriamRequest;
use App\Models\Memoriam;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminMemoriamController extends Controller
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Memoriam::class);

        $data['memoriam'] = Memoriam::withoutGlobalScopes()
            ->sortable()
            ->orderBy('date')
            ->paginate(10);

        return view('admin.memoriams', ['data' => $data]);
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Memoriam::class);

        $memoriam = new Memoriam;

        $data = [
            'memoriam' => $memoriam,
            'action' => 'Create',
        ];

        return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * @param StoreMemoriamRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('create', Memoriam::class);

        $memoriam = new Memoriam($request->input('memoriam'));

        $memoriam->save();

        Session::flash('success', 'You have saved a new memoriam');

        return redirect()->route('admin_memoriam_edit', [$memoriam->slug]);
    }

    /**
     * @param Memoriam $memoriam
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Memoriam $memoriam): View
    {
        $this->authorize('update', Memoriam::class);

        $data = [
            'memoriam' => $memoriam,
            'action' => 'Edit',
        ];

         return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * @param UpdateMemoriamRequest $request
     * @param Memoriam $any_memoriam
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateMemoriamRequest $request, Memoriam $any_memoriam): RedirectResponse
    {
        $this->authorize('update', Memoriam::class);

        $any_memoriam->fill($request->memoriam);
        $any_memoriam->save();

        return redirect()->route('admin_memoriam_edit', $any_memoriam->slug);
    }

    /**
     * @param DestroyMemoriamRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(DestroyMemoriamRequest $request): RedirectResponse
    {
        $this->authorize('delete', Memoriam::class);

        Memoriam::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Memoriam $memoriam) {
                //$this->attachmentService->destroyAttachments($memoriam);
                $memoriam->delete();
            });
        return redirect()->route('admin_memoriam_list');
    }
}
