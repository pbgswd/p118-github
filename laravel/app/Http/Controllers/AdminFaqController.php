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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminFaqController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data['faqs'] = Faq::withoutGlobalScopes()
            ->paginate(20);
        $data['count'] = Faq::withoutGlobalScopes()->count();

        return view('admin.faq_topic_list',['data' => $data]);
    }

    /**
     * @return View
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

        return view('admin.faq_topic_create',['data' => $data]);
    }

    /**
     * @param StoreFaqRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $this->authorize('create', Faq::class);
        $faq = new Faq($request->input('faq'));
        $faq->user_id = Auth::id();
        $faq->save();
        $faq_data = new FaqData($request->input('faq.faq_data.new'));
        $faq_data->faq()->associate($faq);

        $faq_data->save();

        Session::flash('success', 'You have saved a new Faq topic');

        return redirect()->route('admin_faq_create', $faq->slug);
    }

    /**
     * @param Faq $faq
     * @return View
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
     * @param UpdateFaqRequest $request
     * @param Faq $any_faq
     * @param FaqData $any_faq
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateFaqRequest $request, Faq $any_faq, FaqData $faq_data): RedirectResponse
    {
        $this->authorize('update', Faq::class);
        $this->authorize('update', $any_faq);

       // dd($request->all());
      //  dd($any_faq);

        $any_faq->fill($request->faq);
        $any_faq->save();

//todo deal with faq_data
dd($request->faq);

        foreach($request->faq->faq_data as $fd)
        {
            $fd->save();
        }

        if($request->faq->faq_data->new->question != '') {
            $faq_data = new FaqData($request->input('faq.faq_data.new'));
            $faq_data->faq()->associate($any_faq);
            $faq_data->save();
        }

        Session::flash('success', 'You have updated a Faq topic');
        return redirect()->route('admin_faq_edit', [$any_faq->slug]);
    }

    /**
     * @param DestroyFaqRequest $any_faq
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyFaqRequest $any_faq): RedirectResponse
    {
        $this->authorize('delete', Faq::class);
//todo delete faq
        //todo delete faq_data

        Session::flash('success', 'You have deleted a Faq topic');
        return redirect()->route('admin_faqs_list');
    }
}
