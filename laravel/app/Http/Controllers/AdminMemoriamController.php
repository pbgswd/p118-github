<?php

namespace App\Http\Controllers;

use App\Http\Requests\Memoriam\DestroyMemoriamRequest;
use App\Http\Requests\Memoriam\StoreMemoriamRequest;
use App\Http\Requests\Memoriam\UpdateMemoriamRequest;
use App\Models\Memoriam;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminMemoriamController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data['memoriam'] = Memoriam::withoutGlobalScopes()
            ->sortable()
            ->orderBy('date')
            ->paginate(10);

        return view('admin.memoriams', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
     */

    public function store(StoreMemoriamRequest $request): RedirectResponse
    {
        $memoriam = new Memoriam($request->input('memoriam'));

        $memoriam->save();

        Session::flash('success', 'You have saved a new memoriam');

        return redirect()->route('admin_memoriam_edit', [$memoriam->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memoriam  $memoriam
     * @return \Illuminate\Http\Response
     */
    public function edit(Memoriam $memoriam)
    {
        $data = [
            'memoriam' => $memoriam,
            'action' => 'Edit',
        ];

         return view('admin.memoriam', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memoriam  $memoriam
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemoriamRequest $request, Memoriam $any_memoriam): RedirectResponse
    {
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
        Memoriam::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Memoriam $memoriam) {
                //$this->attachmentService->destroyAttachments($memoriam);
                $memoriam->delete();
            });
        return redirect()->route('admin_memoriam_list');
    }
}
