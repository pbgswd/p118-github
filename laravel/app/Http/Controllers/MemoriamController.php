<?php

namespace App\Http\Controllers;

use App\Models\Memoriam;
use App\Models\Options;
use Illuminate\View\View;

class MemoriamController extends Controller
{
    public function index(): View
    {
        $memoriam = Memoriam::sortable()
            ->where('live', 1)
            ->orderBy('date', 'desc')
            ->paginate(9);

        $mem = new Memoriam;

        $data = [
            'memoriam' => $memoriam,
            'folder' => $mem->getAttachmentFolder(),
            'tn_prefix' => Options::memoriam_thumb_values()['tn_str'],
            'title' => 'In Memoriam',
        ];

        return view('memoriams', ['data' => $data]);
    }

    public function show(Memoriam $memoriam): View
    {
        $folder = $memoriam->getAttachmentFolder();

        $data = [
            'memoriam' => $memoriam,
            'folder' => $folder,
            'tn_prefix' => Options::memoriam_thumb_values()['tn_str'],
            'title' => ' - '.$memoriam->title.', In Memoriam',
        ];

        return view('memoriam', ['data' => $data]);
    }
}
