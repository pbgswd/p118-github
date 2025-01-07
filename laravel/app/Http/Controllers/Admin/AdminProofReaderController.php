<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Proofreader;
use App\Services\ProofreaderService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminProofReaderController extends Controller
{
    /**
     * @var ProofreaderService
     */
    private ProofreaderService $proofreaderService;

    public function __construct(ProofreaderService $proofreaderService)
    {
        $this->proofreaderService = $proofreaderService;
    }

    public function index(): View
    {
        $data = [
            'menu' => $this->proofreaderService->getContentNames(),
            'entries' => Proofreader::where('content_type', '')->with('user')->paginate(10),
        ];

        return view('admin.proofreading', ['data' => $data]);
    }

    public function sync(): RedirectResponse
    {
        $pr = new ProofreaderService;
        $pr->sync();
        Session::flash('success', 'You have synced the Proofreader data.');

        return redirect()->route('admin_proofreader');
    }

    public function index_by_entity(Request $request): View
    {
        //todo form request for index by entity
        $type = $request->type;

        $entries = Proofreader::where('content_type', $type)
            ->with('user')
            ->orderBy('content_updated_at', 'desc')
            ->get();

        $data = [
            'entries' => $entries,
            'menu' => $this->proofreaderService->getContentNames(),
        ];

        return view('admin.proofreading', ['data' => $data]);
    }

    public function update(Request $request, Proofreader $proofReader): View
    {

        //todo form request validator

        $proofReader->user_id = Auth::id();
        $proofReader->proofread_at = new Carbon(new \DateTime);

        $proofReader->save();

        Session::flash('success', 'You have proofread the content entry');

        return $this->index_by_entity($request);
    }
}
