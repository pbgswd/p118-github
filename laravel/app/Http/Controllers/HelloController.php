<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HelloController extends Controller
{
    public function index(): View
    {
        /**
        $client = new Predis\Client();
        $client->set('foo', 'bar');
        $value = $client->get('foo');
         **/

        return view('hello', ['data' =>
            ['title' => 'Vancouver Stagehands for Theatre and Live Events']]);
    }
}
