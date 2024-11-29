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
use App\Models\Meeting;
use App\Models\Memoriam;
use App\Models\Message;
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

class AdminSearchController extends Controller
{
    use Sortable;
    /**
     * Display a listing of the resource.
     */
    public function index(AdminSearchResult $request): View
    {
        $data = ['search' => $request->search];
        $data['models']['User'] = [
            'name' => 'Users',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(User::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('email')
                        ->with('user_info')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['UserInfo'] = [
            'name' => 'UserInfo',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(UserInfo::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('about')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        /*
        $data['models']['Executive'] = [
            'name' => 'Executive',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Executive::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addExactSearchableAttribute('email')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ]; */
        $data['models']['Feature'] = [
            'name' => 'Features',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Feature::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Post'] = [
            'name' => 'Posts',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Post::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Page'] = [
            'name' => 'Pages',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Page::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Topic'] = [
            'name' => 'Topics',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Topic::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Attachment'] = [
            'name' => 'Attachments',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Attachment::class, ['file_name', 'description'])
                ->search($request->search),
        ];
        $data['models']['Meeting'] = [
            'name' => 'Meetings',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Meeting::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Committee'] = [
            'name' => 'Committees',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Committee::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['CommitteePost'] = [
            'name' => 'Committee Posts',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(CommitteePost::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Faq'] = [
            'name' => 'Faqs',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Faq::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('faq_topic')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['FaqData'] = [
            'name' => 'Faq Data',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(FaqData::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('question')
                        ->addSearchableAttribute('answer')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Agreement'] = [
            'name' => 'Agreements',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Agreement::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Bylaw'] = [
            'name' => 'Bylaws',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Bylaw::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Policy'] = [
            'name' => 'Policies',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Policy::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Employment'] = [
            'name' => 'Employment',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Employment::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Organization'] = [
            'name' => 'Organizations',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Organization::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Venue'] = [
            'name' => 'Venues',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Venue::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('name')
                        ->addSearchableAttribute('description')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Memoriam'] = [
            'name' => 'In Memoriam',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Memoriam::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('title')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];
        $data['models']['Message'] = [
            'name' => 'In Messages',
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Message::class, static function (ModelSearchAspect $aspect) {
                    $aspect->addSearchableAttribute('subject')
                        ->addSearchableAttribute('content')
                        ->withoutGlobalScope(LiveScope::class);
                })->search($request->search),
        ];

        //todo model names from each search, make jumps to content sections

        $data['count'] = array_reduce($data['models'], function($carry, $array) {
            return $carry + count($array['results']);
        }, 0);

        $data['title'] = $data['count'] .' Search ' .
            Str::plural('Result', $data['count'] ?? 0 ) .
            ' For "' . $data['search'] .'"';

        return view('admin.search_admin', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function show(): View
    {
        $data['models'] = [];
        $data['count'] = 0;
        $data['title'] = "Admin Search";
        return view('admin.search_admin', ['data' => $data]);
    }

    /**
     * @param AdminSearchResult $request
     * @return View
     */
    public function admin_attachment_search(AdminSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search)
                ->registerModel(Attachment::class, ['file_name', 'description',
                    'file_type'])
                ->search($request->search),
        ];
        return view('admin.attachments.list_attachments_search_result', ['data' => $data]);
    }
}
