<?php

namespace App\Http\Controllers;

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

class AdminController extends Controller
{
    protected $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function index(): View
    {
        //Land on the home page of admin. Could have data later.
        //todo grab data from various models, counts, etc, put them on this page

        $emailQueueCount = EmailQueue::count();
        $messagesCount = Message::count();

        $counts['pages'] = Page::count();
        $counts['posts'] = Post::count();
        $counts['topics'] = Topic::count();
        $counts['committees'] = Committee::count();
        $counts['executives'] = Executive::count();
        $counts['faqs'] = Faq::count();
        $counts['features'] = Feature::count();
        $counts['carousels'] = Carousel::count();
        $counts['venues'] = Venue::count();
        $counts['organizations'] = Organization::count();
        $counts['employments'] = Employment::count();
        $counts['minutes'] = Meeting::count();
        $counts['bylaws'] = Bylaw::count();
        $counts['agreements'] = Agreement::count();
        $counts['policies'] = Policy::count();
        $counts['memoriam'] = Memoriam::count();
        $counts['attachments'] = Attachment::count();
        $counts['proofread'] = Proofreader::count();

        $counts['membership'] = Membership::where('membership_type', 'Member')->count();
        $counts['is_banned'] = User::where('is_banned', 1)->count();
        $counts['office'] = Membership::where('membership_type', 'Office')->count();
        $counts['invite'] = count(InviteUser::all());

        //todo make a dependency injection
        $al = new ActivityLog([
            'activity' => Auth::user()->name.' accessed the admin dashboard',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        $activities = ActivityLog::orderBy('id', 'DESC')
            ->limit(5)->get();

        $data = [
            'user' => Auth::user(),
            'activities' => $activities,
            'email_queue_count' => $emailQueueCount,
            'counts' => $counts,
            'messages_count' => $messagesCount,
        ];

        return view('admin.admin', ['data' => $data]);
    }

    public function developer(): View
    {
        return view('admin.developer_admin');
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

        return view('admin.admin-blank');
    }

    public function development(): View
    {
        //todo method for page for development
        //todo file upload
        //todo image library insert image

        return view('admin.admin-development');
    }

    public function getphpinfo(User $user): bool
    {
        return phpinfo();
    }
}
