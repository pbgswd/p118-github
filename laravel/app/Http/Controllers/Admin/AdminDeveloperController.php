<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agreement;
use App\Models\Attachment;
use App\Models\Bylaw;
use App\Models\Carousel;
use App\Models\Committee;
use App\Models\EmailQueue;
use App\Models\Employment;
use App\Models\Executive;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\InviteUser;
use App\Models\Meeting;
use App\Models\Membership;
use App\Models\Memoriam;
use App\Models\Message;
use App\Models\ModelList;
use App\Models\Organization;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use App\Models\Proofreader;
use App\Models\Topic;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDeveloperController extends Controller
{
    protected $activityLog;

    public function __construct()
    {

    }

    public function index(): View
    {
        $data = [
            'user' => Auth::user(),
        ];

        return view('admin.developer.developer_admin', ['data' => $data]);
    }

    public function developer(): View
    {
        return view('admin.developer.developer_admin');
    }

    public function blank(User $user): View
    {
        $mod = new ModelList;
        $arr = ModelList::getModelList();

        $csv = [];
        // $lines = file('../../files/Local118-CSV-Membership.csv', FILE_IGNORE_NEW_LINES);
        $lines = [];
        foreach ($lines as $key => $value) {
            $csv[$key] = str_getcsv($value);
        }

        foreach ($csv as $k => $c) {
            $data[$k]['name'] = $c[0].' '.$c[1];
            $data[$k]['email'] = $c[2];
            $data[$k]['membership_type'] = $c[3];
        }

        return view('admin.developer.admin-blank');
    }

    public function development(): View
    {
        //todo method for page for development
        //todo file upload
        //todo image library insert image

       $data['textarea'] = fake()->paragraph();

        return view('admin.developer.admin-development', ['data' => $data]);
    }
    public function drag(): View
    {
        //todo method for page for development
        //todo file upload
        //todo image library insert image

        $data['textarea'] = fake()->paragraph();

        return view('admin.developer.admin-development', ['data' => $data]);
    }
    public function getphpinfo(User $user): bool
    {
        return phpinfo();
    }
}
