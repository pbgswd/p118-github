<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqData\DestroyFaqDataRequest;
use App\Http\Requests\FaqData\StoreFaqDataRequest;
use App\Http\Requests\FaqData\UpdateFaqDataRequest;
use App\Models\Faq;
use App\Models\FaqData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminFaqDataController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Faq $faq): View
    {

    $faq_data = new FaqData();
    $faq_data['faq'] = $faq;
        $data = [
            'action' => 'Create',
            'faq' => $faq,
            'faq_data' => $faq_data,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.faq_data', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqDataRequest $request, Faq $faq)
    {
        $data = $request->validated();
        $faq_data = new FaqData($data['faq_data']);
        $faq_data->faq_id = $faq->id;
        $faq_data->save();
        Session::flash('info', 'FAQ question and answer created.');


        return redirect()->route('admin_faq_data_edit', ['faq' => $faq->slug, 'faq_data' => $faq_data->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq, FaqData $faqData): View
    {
        $faqData->load('faq','user');
        $data = [
            'faq_data' => $faqData,
            'action' => 'Edit',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(),
                AccessLevelConstants::getConstants()),
        ];

        return view('admin.faq_data', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqDataRequest $request, Faq $faq, FaqData $faqData)
    {
        $data = $request->validated()['faq_data'];
        $faqData->fill($data);
        $faqData->save();

        Session::flash('info', 'FAQ question updated.');

        return redirect()->route('admin_faq_data_edit', ['faq' => $faq->slug, 'faq_data' => $faqData->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyFaqDataRequest $request, FaqData $faqData)
    {
      //  $this->authorize('delete', FaqData::class);

        FaqData::find($request->validated()['id'])
                ->each(function (FaqData $faq_data) {
                $faq_data->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->all()).' Faq Question and Answer'.
            Str::plural('pair', count($request->all())));

        return redirect()->route('admin_faqs_list');
    }
}
