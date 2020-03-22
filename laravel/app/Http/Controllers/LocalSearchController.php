<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\LocalSearch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

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

        $searchResults = (new Search())
            ->registerModel(User::class, 'name')
            ->search($request->search);

        dd($searchResults);

        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         * General site search, topics, posts and pages.
         * also, whatever else is public.
         * sub committees
         * venues
         * tags
         * departments
         * resources
         * people - probably key names, but more when logged in.
         * info
         * search with logged in or logged out state
         * consistently deliver results
         */
        $data['results'] = range(1, 12);

        $data['plural'] = Str::plural('Result', count($data['results']));
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
        //
    }


}
