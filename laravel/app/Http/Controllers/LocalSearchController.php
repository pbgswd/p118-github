<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Bylaw;
use App\Models\Committee;
use App\Models\CommitteePost;
use App\Models\Employment;
use App\Models\Executive;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\Page;
use App\Models\PhoneNumber;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Venue;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class LocalSearchController extends Controller
{
    use Sortable;

    /**
     * @param LocalSearchResult $request
     * @return View
     */
    public function index(LocalSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Post::class, ['title', 'content'])
                ->registerModel(Page::class, ['title', 'content'])
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
                ->registerModel(User::class, 'name')
                ->registerModel(Executive::class, ['title', 'email'])
                ->registerModel(UserInfo::class, 'about')
                ->registerModel(PhoneNumber::class, 'phone_number')
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
     * @param LocalSearchResult $request
     * @return View
     */
    public function admin_search(LocalSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Post::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Page::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
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
                })->registerModel(Executive::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addExactSearchableAttribute('email')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(UserInfo::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('about')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(PhoneNumber::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('phone_number')
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
                })->search($request->search),
        ];

        $data['plural'] = Str::plural('Result', count($data['results']));

        return view('admin.search_admin', ['data' => $data]);
    }

    /**
     * @param LocalSearchResult $request
     * @return View
     */
    public function admin_attachment_search(LocalSearchResult $request): View
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
