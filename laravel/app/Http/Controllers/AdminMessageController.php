<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\DestroyMessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data = [];
        $data['messages'] = Message::sortable()
            ->with('user')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $data['total_messages'] = Message::all()->count();

        return view('admin.messages', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $data['message'] = new Message;
        $data['action'] = 'Create';

        return view('admin.message', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $message = new Message($request->message);
        $message['user_id'] = Auth::id();
        $message->save();
        Session::flash('success', 'A new message, ' . $message->subject .
            ', has been created');
        return redirect()->route('admin_message_edit', $message->id);
    }

    /**
     * @param Message $message
     * @return View
     */
    public function edit(Message $message): View
    {
        $message->load('user');
        $data['message'] = $message;
        $data['action'] = 'Edit';
        return view('admin.message', ['data' => $data]);
    }

    /**
     * @param Request $request
     * @param Message $message
     * @return RedirectResponse
     */
    public function update(Request $request, Message $message): RedirectResponse
    {
        $message->fill($request->message);
        $message->save();
        Session::flash('success', 'You have updated ' . $message->subject);
        return redirect()->route('admin_message_edit', $message->id);
    }

    /**
     * @param Message $message
     * @return View
     */
    public function preview(Message $message): View
    {
        $message->load('user');
        $data['message'] = $message;

        return view('admin.message_preview', ['data' => $data]);
    }

    public function send(Message $message): RedirectResponse
    {
       // dd($message);
//todo select the message to send
// get attachment
// build data with html template for message
// check sending priority
// if now, send to all
// if regular, send to now
// look at date
// mail sending service?
// daily foreach daily, check if a letter exists, if not crate, if exists, append msg
// weekly foreach weekly, check if a letter exists, if not crate, if exists, append msg
// monthly foreach monthly, check if a letter exists, if not crate, if exists, append msg
//

        $message->sent = 1;

        $message->save();


        Session::flash('success', 'The message, ' . $message->subject .
            ', has been sent to the mail queue and is going out now');

        return redirect()->route('admin_messages');
    }


    /**
     * @param DestroyMessageRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyMessageRequest $request): RedirectResponse
    {
        Message::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Message $message) {
                //$this->attachmentService->destroyAttachments($memoriam);
                $message->delete();
            });

        Session::flash('success', 'You have deleted ' . count($request->id)
            . ' ' . Str::plural('message', count($request->id)));

        return redirect()->route('admin_messages');
    }
}
