<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
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
        $emailQueue = Message::where('state', 'sending')
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);

        $data['email_queue'] = $emailQueue;
        $data['count'] = $emailQueue->count();

        return view('admin.messages.email_queue_list', ['data' => $data]);
    }

    public function show(Message $message): View
    {
        $message->load('user', 'attachments');

        $data = [
            'message' => $message,
            'attachments' => $message->attachments,
        ];

        $data['message']['content'] = $message->content;

        return view('emails.email_message', ['data' => $data]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        // todo hide this method as content will be immutable except for development work
        Message::find($request->id)
            ->each(function (Message $emailQueue) {
                $emailQueue->delete();
            });

        Session::flash('success', count($request->id).' '.
            Str::plural('message', count($request->id)).
            ' deleted from the outgoing email queue.');

        return redirect()->route('admin_email_queue_list');
    }
}
