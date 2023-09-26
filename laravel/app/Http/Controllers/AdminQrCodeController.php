<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminQrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $data = ['qrcodes' => Qrcode::withoutGlobalScopes()
            ->paginate(20)];

        return view('admin.qrcodes', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $qr = new Qrcode();
        $data = [
            'qrcode' => $qr,
            'action' => 'Create',
        ];
        return view('admin.qrcode', ['data' => $data]);
    }

    /**
     *  Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /*
         * id, user_id, url, name, file, created_at, updated_at
         */
dd($request->all());

        return redirect()->route('qr_edit', [$qr->url]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Qrcode $qrcode)
    {


        $data = [
            'qr' => $qrcode,
            'action' => 'Create',
        ];
        return view('admin.qrcode', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qrcode $qrcode): RedirectResponse
    {
        //todo delete old qr, update new qr based on data
        echo __METHOD__;
        return redirect()->route('qr_edit', [$qr->url]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qrcode $qrcode): RedirectResponse
    {
        echo __METHOD__;
        return redirect()->route('qrcodes');
    }
}
