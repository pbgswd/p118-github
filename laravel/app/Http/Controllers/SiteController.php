<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

//use Spatie\Sitemap\Sitemap;
//use Spatie\Sitemap\SitemapGenerator;
//use Spatie\Sitemap\Tags\Url;

class SiteController extends Controller
{
    public function index(): View
    {
        /**
        SitemapGenerator::create("https://iatse118.com")
            ->getSitemap()
            ->add(Url::create('/'))
            ->add(Url::create('/pages'))
            ->add(Url::create('/posts'))
            ->add(Url::create('/topics'))
            ->add(Url::create('/executive'))
            ->add(Url::create('/bylaws'))
            ->add(Url::create('/page/links'))
            ->add(Url::create('/memoriams'))
            ->add(Url::create('/agreements'))
            ->add(Url::create('/organizations'))
            ->add(Url::create('/venues'))
            ->add(Url::create('/topic/contract-ratifications'))
            ->writeToFile(public_path().'/sitemap.xml');
         **/

        return view('site', ['data' => ['user' => Auth::user(), 'title' => 'Landing Page']]);
    }
}
