<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HelloController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        /**
        $client = new Predis\Client();
        $client->set('foo', 'bar');
        $value = $client->get('foo');
**/
        Log::debug('Hit home page with ' . __METHOD__ . ' at ' . date('Y-m-d H:i:s'));

        return view('hello');
    }
}
