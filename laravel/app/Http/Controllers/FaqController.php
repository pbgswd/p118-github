<?php

namespace App\Http\Controllers;

use App\Constants\AccessLevelConstants;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        if (Auth::check()) {
            $faqs = Faq::where('live', 1)
             //   ->with('faqsData')
                ->paginate(9);
            $count = Faq::where('live', 1)->count();
        } else {
            $faqs = Faq::where([['access_level', AccessLevelConstants::PUBLIC], ['live', 1]])
               // ->with('faqs_data')
                ->paginate(9);
            $count = Faq::where([['access_level', AccessLevelConstants::PUBLIC], ['live', 1]])->count();
        }
        $data['faqs'] = $faqs;
        $data['count'] = $count;

        return view('faqs',['data' => $data]);
    }


    /**
     * @param Faq $faq
     * @return View
     */
    public function show(Faq $faq): View
    {



        if (false === Auth::check() && $faq->access_level != AccessLevelConstants::PUBLIC) {
            Session::flash('warning', 'Login to view this post.');
            return redirect('login');
        }

        $faq->load('user');
        $faq['faq_data'] = [];
       // $faq->load('faq_data');
        $data = ['faq' => $faq];

        return view('faq', ['data' => $data]);
    }
}
