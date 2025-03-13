<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqData\DestroyFaqDataRequest;
use App\Http\Requests\FaqData\StoreFaqDataRequest;
use App\Http\Requests\FaqData\UpdateFaqDataRequest;
use App\Models\Faq;
use App\Models\FaqData;
use Illuminate\Http\Request;

class AdminFaqDataController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Faq $faq)
    {
        dd([__METHOD__, $faq]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFaqDataRequest $request, Faq $faq)
    {
        dd([__METHOD__, $faq, $request->validated()]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq, FaqData $faqData)
    {
        dd([__METHOD__, $faq, $faqData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqDataRequest $request, Faq $faq, FaqData $faqData)
    {
        dd([__METHOD__, $faq, $faqData, $request->validated()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyFaqDataRequest $request, FaqData $faqData)
    {
        dd([__METHOD__, $faqData, $request->validated()]);
    }
}
