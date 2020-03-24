<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\LocalSearchResult;
use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Bylaw;
use App\Models\Employment;
use App\Models\LocalSearch;
use App\Models\Meeting;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\Venue;
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
                ->registerModel(UserInfo::class, 'about')
                ->search($request->search),
        ];

        $data['plural'] = Str::plural('Result', $data['results']->count());

        return view('admin.search_admin', ['data' => $data]);
    }

    public function admin_attachment_search(LocalSearchResult $request)
    {
        $data = [
            'search' => $request->search,
            'results' => (new Search())
                ->registerModel(Attachment::class, ['file_name', 'description'])
                ->search($request->search),
        ];

        foreach($data['results'] as $d)
        {
            $d->searchable->path_info = pathinfo(storage_path('app/' . $d->searchable->subfolder) . '/' . $d->searchable->file);
            $d->searchable->extension = $d->searchable->path_info['extension'];
            $d->searchable->imagedata = getimagesize(storage_path('app/' . $d->searchable->subfolder) . '/' . $d->searchable->file);
            $d->searchable->filesize =  $this->human_filesize(filesize(storage_path('app/' . $d->searchable->subfolder) . '/' . $d->searchable->file));
            //dd($d->searchable);
        }

        $data['plural'] = Str::plural('Result', $data['results']->count());

        return view('admin.listattachments_search_result', ['data' => $data]);
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


    protected function human_filesize($bytes, $decimals = 2)
    {
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($factor > 0) $sz = 'KMGT';
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor - 1] . 'B';
    }

}
