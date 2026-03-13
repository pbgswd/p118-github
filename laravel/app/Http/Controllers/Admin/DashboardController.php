<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\QboToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

use App\Services\QboService;
class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $qboToken = QboToken::latest()->first();
        $qboConnected = $qboToken !== null && $qboToken->refresh_token_expires_at->isFuture();

        if (!$qboConnected) {
            return redirect()->route('qbo.connect');
        }

        return view('admin.qbo.dashboard', compact('qboConnected'));
    }

}
