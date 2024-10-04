<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Search\AdminSearchResult;
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
use App\Models\LocalSearch;
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
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class AdminSearchController extends Controller
{
    use Sortable;
    /**
     * Display a listing of the resource.
     */
    public function index(AdminSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search)
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

        $data['models'] = ['User','UserInfo','Executive',
            'Feature','Post', 'Page', 'Topic',
            'Meeting','Committee', 'CommitteePost','Faq', 'FaqData',
            'Agreement', 'Bylaw', 'Policy',
            'Employment', 'Organization', 'Venue',
            'Memoriam',];

        //todo break up big search in to individual searches, and then return that with UI context for each Model

        $data['User'] = [
            'name' => 'Users',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(User::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('email')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['UserInfo'] = [
            'name' => 'UserInfo',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(UserInfo::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('about')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Executive'] = [
            'name' => 'Executive',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Executive::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addExactSearchableAttribute('email')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Feature'] = [
            'name' => 'Features',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Feature::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Post'] = [
            'name' => 'Posts',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Post::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Page'] = [
            'name' => 'Pages',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Page::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Topic'] = [
            'name' => 'Topics',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Topic::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Meeting'] = [
            'name' => 'Meetings',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Meeting::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Committee'] = [
            'name' => 'Committees',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Committee::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['CommitteePost'] = [
            'name' => 'Committee Posts',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(CommitteePost::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Faq'] = [
            'name' => 'Faqs',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Faq::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('faq_topic')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['FaqData'] = [
            'name' => 'Faq Data',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(FaqData::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('question')
                        ->addSearchableAttribute('answer')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Agreement'] = [
            'name' => 'Agreements',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Agreement::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Bylaw'] = [
            'name' => 'Bylaws',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Bylaw::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Policy'] = [
            'name' => 'Policies',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Policy::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Employment'] = [
            'name' => 'Employment',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Employment::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Organization'] = [
            'name' => 'Organizations',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Organization::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Venue'] = [
            'name' => 'Venues',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Venue::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['Memoriam'] = [
            'name' => 'In Memoriam',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Memoriam::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];




        $data['plural'] = Str::plural('Result', count($data['results']));

        return view('admin.search_admin', ['data' => $data]);
    }

    public function admin_attachment_search(LocalSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Attachment::class, ['file_name', 'description'])
                ->search($request->search),
        ];

        $data['plural'] = Str::plural('Result', $data['results']->count());

        return view('admin.list_attachments_search_result', ['data' => $data]);
    }

}
