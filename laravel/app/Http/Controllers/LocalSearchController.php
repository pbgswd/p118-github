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
use App\Models\Faq;
use App\Models\FaqData;
use App\Models\Feature;
use App\Models\Meeting;
use App\Models\Memoriam;
use App\Models\Organization;
use App\Models\Page;
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
                ->registerModel(Agreement::class, ['title', 'description'])
                ->registerModel(Bylaw::class, ['title', 'description'])
                ->registerModel(Committee::class, ['name', 'description'])
                ->registerModel(CommitteePost::class, ['title', 'content'])
                ->registerModel(Employment::class, ['title', 'description'])
                ->registerModel(Executive::class, ['title', 'email'])
                ->registerModel(Feature::class, ['title', 'content'])
                ->registerModel(Organization::class, ['name', 'description'])
                ->registerModel(Meeting::class, ['title', 'description'])
                ->registerModel(Memoriam::class, ['title', 'content'])
                ->registerModel(Page::class, ['title', 'content'])
                ->registerModel(Policy::class, ['title', 'description'])
                ->registerModel(Post::class, ['title', 'content'])
                ->registerModel(Topic::class, ['name', 'description'])
                ->registerModel(User::class, 'name')
                ->registerModel(Venue::class, ['name', 'description'])
                ->registerModel(UserInfo::class, 'about')
                ->registerModel(Faq::class, 'faq_topic')
                ->registerModel(FaqData::class, ['question', 'answer'])
                ->search($request->search),
        ];

        //dd(class_basename($data['results'][0]->searchable));
        //dd($data['results'][0]->searchable);
        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         */

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
                })->registerModel(Feature::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Memoriam::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(Faq::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('faq_topic')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->registerModel(FaqData::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('question')
                        ->addSearchableAttribute('answer')
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
