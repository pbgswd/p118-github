<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\DestroyMessageRequest;
use App\Jobs\ProcessMessages;
use App\Models\Committee;
use App\Models\Message;
use App\Models\MessageSending;
use App\Models\Options;
use App\Models\Topic;
use App\Services\AttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    /** @var AttachmentService */
    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function index(): View
    {
        //todo policy
        $data = [];
        $data['messages'] = Message::sortable()
            ->with('user', 'messageMeta', 'messageSending')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $data['total_messages'] = Message::all()->count();

        return view('admin.messages', ['data' => $data]);
    }

    public function create(): View
    {
        //todo policy
        $data = [
            'committee_subscription_options' => Committee::where('live', 1)->get(),
            'topic_subscription_options' => Topic::where('live', 1)->get(),
            'model_subscription_options' => Options::model_subscription_options(),
            'message' => new Message,
            'message_meta_data' => ['source_type' => 'model', 'source_type_name' => 'message'],
            'message_sending' => 'normal',
            'action' => 'Create',
        ];

        return view('admin.message', ['data' => $data]);
    }

    public function store(Request $request): RedirectResponse
    {
        //todo form request validator, policy
        $message = new Message($request->message);
        $message['user_id'] = Auth::id();

        //todo message slug

        $message->save();

        //$message->load('messageSending');

        $message->messageSending()->create(['message_id' => $message->id,
            'send_priority' => $request->message['message_sending']['send_priority']]);

        //todo message_meta_data

        if (! is_null($request->model_source_type_name)) {

            //todo things that belong to any model

            $source_type = 'model';
            $source_type_name = $request->model_source_type_name;

            $source_id = '';
            $source_slug = '';
            $source_url = '';

            if ($request->model_source_type_name == 'Message') {
                $source_id = $message->id;
                $source_slug = '';
                $source_url = strtolower($request->model_source_type_name).'/'.$source_id;
            }
        }

        if (! is_null($request->topic_source_type_name)) {

            //todo things that belong to topic

            $source_id = '';
            $source_slug = '';
            $source_url = '';

            $source_type = 'topic';
            $source_type_name = $request->topic_source_type_name;
        }

        if (! is_null($request->committee_source_type_name)) {

            //todo things that belong to any committee

            $source_id = '';
            $source_slug = '';
            $source_url = '';

            $source_type = 'committee';
            $source_type_name = $request->committee_source_type_name;
        }

        $message->messageMeta()->create(['message_id' => $message->id,
            'source_id' => $source_id,
            'source_slug' => $source_slug,
            'source_type' => $source_type,
            'source_type_name' => $source_type_name,
            'source_url' => $source_url,
        ]);

        //todo save relation, 'messageMeta', 'messageSending'

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $message);

            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'A new message, '.$message->subject.
            ', has been created');

        return redirect()->route('admin_message_edit', $message->id);
    }

    /**
     * @return View
     */
    public function edit(Message $message)
    {
        //todo policy

        $message->load('user', 'attachments', 'messageMeta', 'messageSending');

        if ($message->messageSending->send_status_now == 'sent') {
            Session::flash('warning', 'The message, '.$message->subject.
            ', can no longer be edited because it has been sent to the mail queue');
            // return redirect()->route('admin_messages');

        }

        if ($message->messageSending->send_status_now === 'sent') {
            // Redirect back with an error message or show a message
            return redirect()->back()->with('error', 'You cannot edit content that has already been sent.');
        }
        //todo update relations for form editing and submissions

        $data = [
            'message' => $message,
            'message_meta_data' => ['source_type' => $message->messageMeta->source_type, 'source_type_name' => $message->messageMeta->source_type_name],
            'message_sending' => $message->messageSending->send_priority,
            'committee_subscription_options' => Committee::where('live', '=', 1)->get(),
            'topic_subscription_options' => Topic::where('live', '=', 1)->get(),
            'model_subscription_options' => Options::model_subscription_options(),
            'action' => 'Edit',
        ];

        //dd($data['message']);

        return view('admin.message', ['data' => $data]);
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        //todo form request validator, policy

        $message->load('messageSending');

        if ($message->messageSending->send_status_now === 'sent') {
            // Redirect back with an error message or show a message
            return redirect()->back()->with('error', 'You cannot edit content that has already been sent.');
        }
        $message->fill($request->message);
        $message->save();

        //todo update , 'messageMeta', 'messageSending' relations

        $result = $this->attachmentService->updateAttachment($request, $message);

        if (null !== ($request->attachments)) {
            $result = $this->attachmentService->createAttachment($request, $message);

            if ($result) {
                Session::flash('success', 'You uploaded '.Str::plural('file', $request->attachments));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have updated '.$message->subject);

        return redirect()->route('admin_message_edit', $message->id);
    }

    public function preview(Message $message): View
    {
        //todo policy
        $message->load('user', 'attachments', 'messageMeta', 'messageSending');
        $data = [
            'message' => $message,
            'message_meta_data' => ['source_type' => $message->messageMeta->source_type, 'source_type_name' => $message->messageMeta->source_type_name],
            'message_sending' => $message->messageSending->send_priority,
        ];

        //todo get attachments

        return view('admin.message_preview', ['data' => $data]);
    }

    public function preview_strict(Message $message): View
    {
        //todo policy
        //todo sort out email queue vs message table
        $message->load('user', 'attachments', 'messageMeta', 'messageSending');

        $data = [
            'message' => $message,
            'message_meta_data' => ['source_type' => $message->messageMeta->source_type, 'source_type_name' => $message->messageMeta->source_type_name],
            'message_sending' => $message->messageSending->send_priority,
            'attachments' => $message->attachments,
        ];

        return view('emails.email_message', ['data' => $data]);
    }

    public function send(Message $message): RedirectResponse
    {
        //todo policy
        Log::info('About to move command to jobs table '.$message->id);

        $message->save();

        $messageSending = MessageSending::where('message_id', $message->id)
            ->update(
                [
                    'send_status_now' => 'send',
                    'send_status_daily' => 'send',
                    'send_status_weekly' => 'send',
                ]
            );

        Log::info('About to execute ProcessMessages dispatch for message with id '.$message->id);

        ProcessMessages::dispatch(['log' => 'delay message by a certain amount'])
            ->delay(now()->isFriday('17:00'));
        //->delay(now()->addMinutes(10));

        ProcessMessages::dispatch(['log' => __FILE__.' '.' Sending the message '.$message->subject, 'id' => $message->id]);

        Log::info('ProcessMessages dispatch has been executed for message with id '.$message->id);

        Session::flash('success', 'The message, '.$message->subject.', has been sent to the mail queue and is going out now');

        return redirect()->route('admin_messages');
    }

    public function destroy(DestroyMessageRequest $request): RedirectResponse
    {
        //todo form request validator, policy
        Message::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Message $message) {
                //todo only destroy attachments if not from other content
                $this->attachmentService->destroyAttachments($message);
                $message->messageMeta()->delete();
                $message->messageSending()->delete();
                $message->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->id).' '.Str::plural('message', count($request->id)).'.');

        return redirect()->route('admin_messages');
    }
}
