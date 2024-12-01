<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\DestroyMessageRequest;
use App\Jobs\ProcessMessages;
use App\Models\Committee;
use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\MessageCategory;
use App\Models\Options;
use App\Models\Topic;
use App\Models\User;
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
            ->with('user')
            ->orderBy('id', 'DESC')
            ->paginate(20);

        $data['total_messages'] = Message::all()->count();
        $data['total_emails_sent'] = Message::sum('count');
        $data['not_sent'] = Message::where('state', 'not_sent')->count();
        $data['sending'] = Message::where('state', 'sending')->count();
        $data['sent'] = Message::where('state', 'sent')->count();

        return view('admin.messages.messages', ['data' => $data]);
    }

    public function create(): View
    {
        //todo policy, intitial state for pull down menus

        //todo selected value in each collection
        $data = [
            'committee_subscription_options' => Committee::where('live', 1)
                ->get()
                ->map(function ($committee) {
                    $committee->selected = '';
                    return $committee;
                }),
            'topic_subscription_options' => Topic::where('live', 1)
                ->get()
                ->map(function ($topic) {
                    $topic->selected = '';
                    return $topic;
                }),
            'model_subscription_options' => collect(Options::model_subscription_options())
                ->map(function ($model) {
                    $model['selected'] = '';
                    return $model;
                }),
            'message' => new Message,
            'message_meta_data' => ['source_type' => 'model', 'source_type_name' => 'message'],
            'message_sending' => 'normal',
            'action' => 'Create',
        ];

        return view('admin.messages.message', ['data' => $data]);
    }

    public function store(Request $request): RedirectResponse
    {
        //todo form request validator, policy
        $message = new Message($request->message);

        $message['user_id'] = Auth::id();
        $message['slug'] = Str::slug($message['subject'], '-'); // model method?

        $message->save();
        $message['source_url'] = env('APP_URL') . '/message/' . $message['id'] . "/" . $message['slug'];
        $message->save();

        foreach ($request['source_type'] as $category) {
            foreach ($category as $cat) {
                [$type, $name] = explode(' ', $cat);
                $data['message_id'] = $message->id;
                $data['type'] = $type;
                $data['name'] = $name;
                $mc = new MessageCategory($data);
                $mc->save();
            }
        }

        if (null !== ($request->file('attachments'))) {
            $result = $this->attachmentService->createAttachment($request, $message);
            if ($result) {
                Session::flash('success', 'You uploaded '.count($request->file('attachments')).' files');
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'A new message, ' . $message->subject . ', has been created');

        return redirect()->route('admin_message_edit', [$message->id, $message->slug]);
    }

    /**
     * @return View
     */
    public function edit(Message $message)
    {
        //todo policy

        $message->load(['user', 'attachments']);

        $message_categories = MessageCategory::where('message_id', $message->id)->get();
        $mc_data = [];
        foreach($message_categories as $mc) {
            $mc['field'] = $mc->type . " " . $mc->name;
            $mc_data[] = $mc;
        }

 //todo sort out message_categories data so it can be handled by the blade template

        if ($message->state == 'sending') {
            Session::flash('warning', 'The message, '.$message->subject.
            ', can no longer be edited because it has been sent to the mail queue');
            return redirect()->back()->with('error', 'You cannot edit content because it has been sent to the mail queue.');
        }

        if ($message->state == 'sent') {
            // Redirect back with an error message or show a message
            return redirect()->back()->with('error', 'You cannot edit content that has already been sent.');
        }



        $committee_options = Committee::where('live', 1)
            ->get()
            ->map(function ($committee) use ($mc_data) {
                $isSelected = count(array_filter($mc_data, function ($mcItem) use ($committee) {
                        return $mcItem->type === 'committee' &&
                            'committee ' . $committee->slug === $mcItem['field'];
                    })) > 0;
                $committee->selected = $isSelected ? 'selected' : '';
                return $committee;
            });

        $counts['committee'] = $committee_options
            ->filter(function ($committee) {
                return $committee['selected'] === 'selected';
            })
            ->count();

        $topic_options = Topic::where('live', 1)
            ->get()
            ->map(function ($topic) use ($mc_data) {
                $isSelected = count(array_filter($mc_data, function ($mcItem) use ($topic) {
                        return $mcItem->type === 'topic' &&
                            'topic ' . $topic->slug === $mcItem['field'];
                    })) > 0;
                $topic->selected = $isSelected ? 'selected' : '';
                return $topic;
            });

        $counts['topic'] = $topic_options
            ->filter(function ($topic) {
                return $topic['selected'] === 'selected';
            })
            ->count();

        $model_options = collect(Options::model_subscription_options())
            ->map(function ($model) use ($mc_data) {
                $isSelected = count(array_filter($mc_data, function ($mcItem) use ($model) {
                        return $mcItem->type === 'model' &&
                            'model ' . $model['model'] === $mcItem['field'];
                    })) > 0;
                $model['selected'] = $isSelected ? 'selected' : '';
                return $model;
            });

        $counts['model'] = $model_options
            ->filter(function ($model) {
                return $model['selected'] === 'selected';
            })
            ->count();

        $counts['total'] = array_sum($counts);

        $counts['recipients'] = User::where('is_banned', '!=', 1)
            ->whereHas('message_selections', function ($query)  use ($message) {
                $query->whereExists(function ($subQuery) use ($message) {
                    $subQuery->select('*')
                        ->from('message_categories')
                        ->whereRaw('message_categories.type = message_selections.type')
                        ->whereRaw('message_categories.name = message_selections.name')
                        ->whereRaw('message_categories.message_id = ?', [$message->id]);
                });
            })
            ->distinct()
            ->count();

        $data = [
            'message' => $message,
            'message_categories' => $mc_data,
            'committee_subscription_options' => $committee_options,
            'topic_subscription_options' => $topic_options,
            'model_subscription_options' => $model_options,
            'counts' => $counts,
            'action' => 'Edit',
        ];

        return view('admin.messages.message', ['data' => $data]);
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        //todo form request validator, policy

        if ($message->state === 'sent') {
            // Redirect back with an error message or show a message
            return redirect()->back()->with('error', 'You cannot edit content that has already been sent.');
        }

        $message->fill($request->message);
//todo update it properly. if it is from message, just the slug. If it is from another model, the whole thing?
        $message['source_url'] = env('APP_URL') . '/message/' . $message['id'] . "/" . $message['slug'];

        $sections = ['model', 'topic', 'committee'];

        MessageCategory::where('message_id', $message->id)->delete();

        foreach ($request['source_type'] as $category) {
            foreach ($category as $cat) {
                [$type, $name] = explode(' ', $cat);
                $data['message_id'] = $message->id;
                $data['type'] = $type;
                $data['name'] = $name;
                $mc = new MessageCategory($data);
                $mc->save();
            }
        }
        $message->save();

        $result = $this->attachmentService->updateAttachment($request, $message);
        if (null !== ($request->attachments)) {
            $result = $this->attachmentService->createAttachment($request, $message);
            if ($result) {
                Session::flash('success', 'You uploaded '.Str::plural('file', $request->attachments));
            } else {
                Session::flash('error', 'You have an upload problem');
            }
        }

        Session::flash('success', 'You have updated ' . $message->subject);

        return redirect()->route('admin_message_edit', [$message->id, $message->slug]);
    }

    public function preview(Message $message): View
    {
        $message->load('user', 'attachments');
        //todo message categories info
        $data = [
            'message' => $message,
        ];

        return view('admin.messages.message_preview', ['data' => $data]);
    }

    public function preview_strict(Message $message): View
    {
        $message->load('user', 'attachments');
        $data = [
            'message' => $message,
            'attachments' => $message->attachments,
        ];
        return view('emails.email_message', ['data' => $data]);
    }

    public function send(Message $message): RedirectResponse
    {
        //todo policy
        Log::info('About to move command to jobs table '.$message->id);
        // Log::info('About to execute ProcessMessages dispatch for message with id '.$message->id);
        // ProcessMessages::dispatch(['id' => $message->id]);
        // Log::info('ProcessMessages dispatch has been executed for message with id '.$message->id);

         $subs = User::where('is_banned', '!=', 1)
             ->whereHas('message_selections', function ($query)  use ($message) {
                 $query->whereExists(function ($subQuery) use ($message) {
                     $subQuery->select('*')
                         ->from('message_categories')
                         ->whereRaw('message_categories.type = message_selections.type')
                         ->whereRaw('message_categories.name = message_selections.name')
                         ->whereRaw('message_categories.message_id = ?', [$message->id]);
                 });
             })
             ->distinct()
             ->get();

        foreach ($subs as $sub) {
            $emailQueueMsg = new EmailQueue([
                'message_id' => $message->id,
                'user_id' => $sub->id,
            ]);
            $emailQueueMsg->save();
        }

        $message->state = 'sending';
        $message->save();

        Session::flash('success', 'The message, ' . $message->subject .
            ', has been sent to the mail queue and is going out now');

        return redirect()->route('admin_messages');
    }

    public function destroy(DestroyMessageRequest $request): RedirectResponse
    {
        //todo form request validator, policy

        Message::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Message $message) {
                MessageCategory::where('message_id', $message->id)->delete();
                //todo only destroy attachments if not from other content
                $this->attachmentService->destroyAttachments($message);
                $message->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->id) .' '.
            Str::plural('message', count($request->id)).'.');

        return redirect()->route('admin_messages');
    }
}
