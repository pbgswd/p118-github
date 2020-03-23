<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\Agreement;
use App\Models\Bylaw;
use App\Models\Employment;
use App\Models\LocalSearch;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
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

        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Post::class, ['title', 'description', 'content'])
                ->registerModel(Page::class, ['title', 'description', 'content'])
                ->registerModel(Topic::class, ['name', 'description'])
                ->registerModel(Agreement::class, ['title', 'description'])
                ->registerModel(Bylaw::class, ['title', 'description'])
                ->registerModel(Employment::class, ['title', 'description'])
                ->registerModel(Meeting::class, ['title', 'description'])
                ->registerModel(Organization::class, ['name', 'description'])
                ->registerModel(Venue::class, ['name', 'description'])
                ->registerModel(User::class, 'name')
                ->search($request->search),
        ];

        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         * General site search, topics, posts and pages.
         * also, whatever else is public.
         *
         * sub committees posts, post comments
         * venues
         * agreements
         * bylaws
         * jobs
         * minutes
         *
         * tags
         * organizations
         *
         * pages posts topics users
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
