<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Bylaw;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\CommitteePostComment;
use App\Models\Employment;
use App\Models\LocalSearch;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Venue;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class LocalSearchController extends Controller
{
    use Sortable;
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
                ->registerModel(Policy::class, ['title', 'description'])
                ->registerModel(Employment::class, ['title', 'description'])
                ->registerModel(Meeting::class, ['title', 'description'])
                ->registerModel(Organization::class, ['name', 'description'])
                ->registerModel(Venue::class, ['name', 'description'])
                ->registerModel(Committee::class, ['name', 'description'])
                ->registerModel(CommitteePost::class, ['title', 'content'])
                ->registerModel(CommitteePostComment::class, ['content'])
                ->registerModel(User::class, 'name')
                ->registerModel(UserInfo::class, 'about')
                ->search($request->search),
        ];

        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         */

        $data['plural'] = Str::plural('Result', $data['results']->count());

        return view('search', ['data' => $data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function admin_search(LocalSearchResult $request)
    {

        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Post::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Page::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Topic::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Agreement::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Bylaw::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Employment::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Meeting::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Organization::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Venue::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(User::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(UserInfo::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('about')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Policy::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addExactSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Committee::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(CommitteePost::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(CommitteePostComment::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })
            ->search($request->search)
        ];

        $data['plural'] = Str::plural('Result', count($data['results']));

        return view('admin.search_admin', ['data' => $data]);
    }

    public function admin_attachment_search(LocalSearchResult $request)
    {
        //todo dont crash search when file is not on host
        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Attachment::class, ['file_name', 'description'])
                ->search($request->search),
        ];

        $data['plural'] = Str::plural('Result', $data['results']->count());

        return view('admin.list_attachments_search_result', ['data' => $data]);
    }
}
