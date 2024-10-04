<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        self::deleteOlderRecords();

        $data['activities'] = ActivityLog::sortable()
            ->orderBy('id', 'DESC')
            ->paginate(20);

        return view('admin.activity_log.activity_logs_list', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request): void
    {
        $activityLog = new ActivityLog($request);
        //$activityLog['ip_address'] = $_SERVER['REMOTE_ADDR'];
        // $activityLog['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        // $activityLog['model'] = $request['model'];

        $activityLog->save();
    }

    public function deleteOlderRecords(): void
    {
        // Step 1: Get the IDs of the latest 20 records
        $latestIds = ActivityLog::orderBy('created_at', 'desc') // Or use another column like 'id'
            ->take(100)
            ->pluck('id');

        // Step 2: Delete all records that are not in the latest 20
        ActivityLog::whereNotIn('id', $latestIds)
            ->delete();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        Session::flash('success', 'You have deleted '.count($activityLog->id)
            .' '.Str::plural('message', count($activityLog->id)).'.');
        Session::flash('warning', 'not deleting yet');
    }
}
