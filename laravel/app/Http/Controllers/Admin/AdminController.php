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

class AdminController extends Controller
{
    protected $activityLog;

    public function __construct()
    {

    }

    public function index(): View
    {
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
        $counts['total_messages'] = Message::all()->count();
        $counts['total_emails_sent'] = Message::sum('count');
        $counts['not_sent'] = Message::where('state', 'not_sent')->count();
        $counts['sending'] = Message::where('state', 'sending')->count();
        $counts['sent'] = Message::where('state', 'sent')->count();
        $emailQueueCount = EmailQueue::count();
        $messagesCount = Message::count();
        //todo look at events in Laravel https://laravel.com/docs/11.x/events
        $al = new ActivityLog([
            'activity' => Auth::user()->name . ' accessed the admin dashboard',
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'model' => 'Admin']);
        $al->save();

        $activities = ActivityLog::orderBy('id', 'DESC')
            ->limit(5)->get();

        $users['admin'] = User::where('is_banned', 0)->whereHas('roles', function ($q) {
            $q->where('name', 'super-admin');
        })->get();

        $users['writer'] = User::where('is_banned', 0)->whereHas('roles', function ($q) {
            $q->where('name', 'writer');
        })->get();

        $users['office'] = User::where('is_banned', 0)->whereHas('roles', function ($q) {
            $q->where('name', 'office');
        })->get();

        $users['committee'] = User::where('is_banned', 0)->whereHas('roles', function ($q) {
            $q->where('name', 'committee');
        })->get();

        $data = [
            'user' => Auth::user(),
            'users' => $users,
            'activities' => $activities,
            'email_queue_count' => $emailQueueCount,
            'counts' => $counts,
            'messages_count' => $messagesCount,
        ];

        return view('admin.admin', ['data' => $data]);
    }
}
