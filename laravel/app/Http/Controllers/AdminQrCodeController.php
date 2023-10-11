<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRC;

class AdminQrCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $data = ['qrcodes' => Qrcode::paginate(20)];

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
            'size' => range(100, 1100, 100),
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
        $qrcode = new Qrcode($request->qrcode);
        $qrcode->user_id = Auth::id();
        //todo create qr file

        $data = QRC::generate('Make me into a QrCode!');

        //dd($data);

        $qrcode->file = "fakefile.jpg";
        $qrcode->save();

        Session::flash('success', 'New QR code saved');


        return redirect()->route('admin_qrcode_edit', [$qrcode->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Qrcode $qrcode)
    {
        $qrcode->load('user');
        //todo load qr file
        $data = [
            'qrcode' => $qrcode,
            'action' => 'Edit',
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

        $qrcode->fill($request->qrcode);
        $qrcode->save();
        //todo delete qr file
        //todo create qr file
        Session::flash('success', 'QR code updated');
        return redirect()->route('admin_qrcode_edit', [$qrcode->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request): RedirectResponse
    {

       // dd($request->all());
        Qrcode::find($request->id)
            ->each(function (Qrcode $qrcode) {

                //todo delete qr file

                $qrcode->delete();
            });

        Session::flash('success', 'QR code deleted');
        return redirect()->route('admin_qrcodes_list');
    }
}
