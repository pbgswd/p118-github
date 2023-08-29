<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
dd($request->all());
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
    public function update(Request $request, Qrcode $qrcode)
    {
        echo __METHOD__;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qrcode $qrcode)
    {
        echo __METHOD__;
    }
}
