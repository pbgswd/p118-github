<?php

namespace App\Http\Controllers;

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
        return view('hello');
    }
}
