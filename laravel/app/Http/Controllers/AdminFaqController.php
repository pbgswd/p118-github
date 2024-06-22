<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Http\Requests\Faq\DestroyFaqRequest;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Models\Faq;
use App\Models\FaqData;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminFaqController extends Controller
{
    public function index(): View
    {
        $data['faqs'] = Faq::withoutGlobalScopes()
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);
        $data['count'] = Faq::withoutGlobalScopes()->count();

        return view('admin.faq_topic_list', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Faq::class);

        $data = [
            'faq' => new Faq(),
            'action' => 'Create',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.faq_topic_create', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $this->authorize('create', Faq::class);

        $faq = new Faq($request->input('faq'));
        $faq->user_id = Auth::id();
        $faq->save();
        if ($request->new['question'] != '') {
            $faq_data = new FaqData($request->input('new'));
            $faq_data->faq()->associate($faq);
            $faq_data->save();
        }

        Session::flash('success', 'You have saved a new Faq topic');

        return redirect()->route('admin_faq_create', $faq->slug);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Faq $faq): View
    {
        $this->authorize('update', Faq::class);

        $faq->load(['faqs_data', 'user'])->orderBy('faqs_data.sort_order', 'desc');

        $data = [
            'faq' => $faq,
            'action' => 'Update',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.faq_topic_create', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateFaqRequest $request, Faq $any_faq): RedirectResponse
    {
        $this->authorize('update', Faq::class);
        $this->authorize('update', $any_faq);

        $any_faq->fill($request->faq);
        $any_faq->save();

        $faq = Faq::latest()->first();

        if (isset($request->faq['faq_data'])) {
            foreach ($request->faq['faq_data'] as $fd) {
                if ($fd['delete'] == 1) {
                    FaqData::where('id', $fd['id'])->delete();
                } else {
                    unset($fd['delete']);
                    $faq->faqs_data()->upsert([$fd], ['id']);
                }
            }
        }

        if ($request->new['question'] != '') {
            $faq_data = new FaqData($request->input('new'));
            $faq_data->faq()->associate($any_faq);
            $faq_data->save();
        }

        Session::flash('success', 'You have updated a Faq topic');

        return redirect()->route('admin_faq_edit', [$any_faq->slug]);
    }

    /**
     * @param  DestroyFaqRequest  $any_faq
     *
     * @throws AuthorizationException
     */
    public function destroy(DestroyFaqRequest $request): RedirectResponse
    {
        $this->authorize('delete', Faq::class);

        Faq::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Faq $faq) {
                $faq->faqs_data()->delete();
                $faq->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->all()).' Faq '.
            Str::plural('topic', count($request->all())));

        return redirect()->route('admin_faqs_list');
    }
}
