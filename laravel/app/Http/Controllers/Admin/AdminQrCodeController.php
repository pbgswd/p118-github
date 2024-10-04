<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Qrcode\DestroyQrcodeRequest;
use App\Http\Requests\Qrcode\StoreQrcodeRequest;
use App\Http\Requests\Qrcode\UpdateQrcodeRequest;
use App\Models\Qrcode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QRC;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminQrCodeController extends Controller
{
    public function index(): View
    {
        $data = ['qrcodes' => Qrcode::paginate(20)];
        $data['count'] = count(Qrcode::all());

        return view('admin.qrcodes', ['data' => $data]);
    }

    public function create(): View
    {
        $qr = new Qrcode;

        $data = [
            'qrcode' => $qr,
            'size' => range(100, 1100, 100),
            'action' => 'Create',
        ];

        return view('admin.qrcode', ['data' => $data]);
    }

    public function store(StoreQrcodeRequest $request): RedirectResponse
    {
        $qrcode = new Qrcode($request->qrcode);
        $directory = $qrcode->getAttachmentFolder();

        $qrcode->user_id = Auth::id();

        $size = 300;
        $format = 'png';
        $logo = 'public/pXtRRslxfpjHCyakkCXrufsP43qtBN4EwkXxjnQz.png';
        $coverage = 0.2;
        $errorCorrection = 'H';

        $data = QRC::format($format)
            ->size($size)
            ->mergeString(Storage::get($logo), $coverage)
            ->errorCorrection($errorCorrection)
            ->generate($qrcode->qrdata);

        $qrcode->file = md5($qrcode->name).'.png';
        Storage::disk($directory)->put($qrcode->file, $data);

        $qrcode->save();

        Session::flash('success', 'New QR code, '.$qrcode->name.' saved');

        return redirect()->route('admin_qrcode_edit', [$qrcode->id]);
    }

    public function edit(Qrcode $qrcode): View
    {
        $qrcode->load('user');
        //todo load qr file
        $data = [
            'qrcode' => $qrcode,
            'action' => 'Edit',
        ];

        return view('admin.qrcode', ['data' => $data]);
    }

    public function update(UpdateQrcodeRequest $request, Qrcode $qrcode): RedirectResponse
    {
        $directory = $qrcode->getAttachmentFolder();
        $qrcode->fill($request->qrcode);

        Storage::disk($directory)->delete($qrcode->file);

        $size = 300;
        $format = 'png';
        $logo = 'public/pXtRRslxfpjHCyakkCXrufsP43qtBN4EwkXxjnQz.png';
        $coverage = 0.2;
        $errorCorrection = 'H';

        $data = QRC::format($format)
            ->size($size)
            ->mergeString(Storage::get($logo), $coverage)
            ->errorCorrection($errorCorrection)
            ->generate($qrcode->qrdata);

        $qrcode->file = md5($qrcode->name).'.png';

        Storage::disk($directory)->put($qrcode->file, $data);
        $qrcode->save();

        Session::flash('success', 'QR code updated');

        return redirect()->route('admin_qrcode_edit', [$qrcode->id]);
    }

    public function download(Qrcode $qrcode): StreamedResponse
    {
        $directory = $qrcode->getAttachmentFolder();

        //dd($qrcode);
        return Storage::download($directory.'/'.$qrcode['file'],
            $qrcode['name'], ['Content-Disposition' => 'inline; filename="'.$qrcode['name'].'"']);
    }

    public function destroy(DestroyQrcodeRequest $request): RedirectResponse
    {
        Qrcode::find($request->id)
            ->each(function (Qrcode $qrcode) {
                Storage::disk('qrcodes')->delete($qrcode->file);
                $qrcode->delete();
            });

        Session::flash('success', count($request->id).' QR '.Str::plural('code', count($request->id)).' deleted');

        return redirect()->route('admin_qrcodes_list');
    }
}
