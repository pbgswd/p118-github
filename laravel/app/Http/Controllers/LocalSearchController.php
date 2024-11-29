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

class LocalSearchController extends Controller
{
    use Sortable;

    public function index(LocalSearchResult $request): View
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search)
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
                //->registerModel(FaqData::class, ['question', 'answer'])
                ->registerModel(Message::class, ['subject', 'content'])
                ->search($request->search),
        ];

        //dd(class_basename($data['results'][0]->searchable));
        //dd($data['results'][0]->searchable);
        /*
         * https://laraveldaily.com/new-package-laravel-searchable-easily-search-in-multiple-models/
         * https://packagist.org/packages/spatie/laravel-searchable
         * https://medium.com/justlaravel/search-functionality-in-laravel-a2527282150b
         */

        $data['title'] = 'Search Results for '.$request->search;

        return view('search', ['data' => $data]);
    }
}
