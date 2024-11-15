<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEmailQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $emailQueue = EmailQueue::withoutGlobalScopes()
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        $data['email_queue'] = $emailQueue;
        $data['count'] = EmailQueue::withoutGlobalScopes()->count();

        return view('admin.messages.email_queue_list', ['data' => $data]);
    }

    /**
     * @param EmailQueue $email_queue
     * @return View
     */
    public function show(EmailQueue $email_queue): View
    {
        $attachments = '';

        if (! is_null($email_queue->attachments)) {
            unserialize($email_queue->attachments);
            //todo prep for link attachments data
        }

        $data = [
            'message' => $email_queue,
            'attachments' => $attachments,
        ];

        $data['message']['content'] = $email_queue->message;

        return view('emails.email_message', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        EmailQueue::withoutGlobalScopes()->find($request->id)
            ->each(function (EmailQueue $emailQueue) {
                $emailQueue->delete();
            });

        Session::flash('success', count($request->id) . ' ' .
            Str::plural('message', count($request->id)) .
            ' deleted from the outgoing email queue.');

        return redirect()->route('admin_email_queue_list');
    }
}
