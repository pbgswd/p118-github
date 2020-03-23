<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\LocalSearch;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Spatie\Searchable\Search;

class LocalSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(LocalSearchResult $request)
    {

        $data['search'] = $request->search;

        $data['results'] = (new Search())
            ->registerModel(Post::class, ['title', 'description', 'content'])
            ->registerModel(Page::class, ['title', 'description', 'content'])
            ->registerModel(Topic::class, ['name', 'description'])
            ->registerModel(User::class, 'name')
            ->search($request->search);

        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         * General site search, topics, posts and pages.
         * also, whatever else is public.
         *
         * sub committees
         * venues
         * agreements
         * bylaws
         * jobs
         * minutes
         * tags
         * 
         * tags
         * departments
         * resources
         * people - probably key names, but more when logged in.
         * info
         * search with logged in or logged out state
         * consistently deliver results
         */

        $data['plural'] = Str::plural('Result', $data['results']->count());
        return view('search', ['data' => $data]);
    }


    /**
     * Display the specified resource.
     *
     * @param LocalSearch $search
     * @return Response
     */
    public function show(LocalSearch $search)
    {
        dd(__METHOD__);
    }


}
