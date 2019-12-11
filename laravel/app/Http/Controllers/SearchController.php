<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchResult;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(SearchResult $request)
    {
        $data = [];
        $data['search'] = $request->search;
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Search $search
     * @return Response
     */
    public function show(Search $search)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Search $search
     * @return Response
     */
    public function edit(Search $search)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Search $search
     * @return Response
     */
    public function update(Request $request, Search $search)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Search $search
     * @return Response
     */
    public function destroy(Search $search)
    {
        //
    }
}
