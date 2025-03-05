<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\DestroyMessageRequest;
use App\Http\Requests\Messages\StoreMessageRequest;
use App\Http\Requests\Messages\UpdateMessageRequest;
use App\Jobs\ProcessMessages;
use App\Models\Committee;
use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\MessageCategory;
use App\Models\MessageSelection;
use App\Models\Options;
use App\Models\Topic;
use App\Models\User;
use App\Services\AttachmentService;
use App\Services\MessageAttachmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMessageController extends Controller
{
    private MessageAttachmentService $attachmentService;

    public function __construct(MessageAttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function index(): View
    {
        //todo policy
        $data = [];

        $topics = Topic::where('live', 1)
            ->withCount(['message_selections as user_count' => function ($query) {
                $query->where('type', 'topic');
            }])
            ->get();

        $committees = Committee::where('live', 1)
            ->withCount(['message_selections as user_count' => function ($query) {
                $query->where('type', 'committee');
            }])
            ->get();

        $subscriber_count = MessageSelection::distinct('user_id')->count('user_id');
        $users = User::all()->count();

        $models = collect(Options::model_subscription_options())->mapWithKeys(function ($modelOption) {
            return [
                $modelOption['name'] => MessageSelection::where('type', 'model')
                    ->where('name', $modelOption['model'])
                    ->distinct('user_id')
                    ->count('user_id')
            ];
        });

        $data = [
            'total_messages' => Message::all()->count(),
            'total_emails_sent' => Message::sum('count'),
            'subscriber_count' => MessageSelection::distinct('user_id')->count('user_id'),
            'users' => User::all()->count(),
            'not_sent' => Message::where('state', 'not_sent')->count(),
            'sending' => Message::where('state', 'sending')->count(),
            'sent' => Message::where('state', 'sent')->count(),
            'categories' => [
                'Topics' => $topics,
                'Models' => $models,
                'Committees' => $committees,
                ],
            ];

        $data['messages'] = Message::sortable()
            ->with('user')
            ->orderBy('id', 'DESC')
            ->paginate(20);

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

    public function store(StoreMessageRequest $request): RedirectResponse
    {
        $sourceTypes = $request->input('source_type');

        if (empty($sourceTypes['topic']) && empty($sourceTypes['model']) && empty($sourceTypes['committee'])) {
            return redirect()->back()->with('error', 'Please select at least one message category.');
        }

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
        $message->load(['user', 'attachments', 'messageCategories']);

        $mc_data = [];
        foreach($message['messageCategories'] as $mc) {
            $mc['field'] = $mc->type . " " . $mc->name;
            $mc_data[] = $mc;
        }

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

    public function update(UpdateMessageRequest $request, Message $message): RedirectResponse
    {
        //todo policy

        $sourceTypes = $request->input('source_type');

        if (empty($sourceTypes['topic']) && empty($sourceTypes['model']) && empty($sourceTypes['committee'])) {
            return redirect()->back()->with('error', 'Please select at least one message category.');
        }

        if ($message->state === 'sent') {
            // Redirect back with an error message or show a message
            return redirect()->back()->with('error', 'You cannot edit content that has already been sent.');
        }

        $data = $request->validated();

        $data['message']['slug'] = Str::slug($data['message']['subject'], '-');

        $data['message']['source_url'] = $message->source_url;

        if(strstr($message->source_url, '/message/')) {
            $data['message']['source_url'] = env('APP_URL') . '/message/' . $message['id'] . "/" . $data['message']['slug'];
        }

        $message->fill($data['message']);
        $message->save();

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
        $message->load('user', 'attachments', 'messageCategories');

        $data = [
            'message' => $message,
        ];

        return view('admin.messages.message_preview', ['data' => $data]);
    }

    public function preview_strict(Message $message): View
    {
        $message->load('user', 'attachments', 'messageCategories');
        $data = [
            'message' => $message,
            'attachments' => $message->attachments,
        ];
        return view('emails.email_message', ['data' => $data]);
    }

    public function send(Message $message): RedirectResponse
    {
        //todo policy committee, content mgrs
        Log::info('About to move command to jobs table '.$message->id);
        // Log::info('About to execute ProcessMessages dispatch for message with id '.$message->id);
        //todo put ProcessMessages to work.
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

    public function test_send(Message $message): RedirectResponse
    {
         $emailQueueMsg = new EmailQueue([
            'message_id' => $message->id,
            'user_id' => Auth::user()->id,
        ]);

        $emailQueueMsg->save();

        $message->state = 'testing';
        $message->save();

        Log::info('Test message ' . $message->subject .' sent to ' . Auth::user()->name );

        Session::flash('success', 'The message, ' . $message->subject .
            ', has been sent to the mail queue and is going out now as a test only to you');

        return redirect()->route('admin_message_edit', [$message->id, $message->slug]);
    }


    public function destroy(DestroyMessageRequest $request): RedirectResponse
    {
        Message::find($request->id)
            ->each(function (Message $message) {
                MessageCategory::where('message_id', $message->id)->delete();
                $this->attachmentService->destroyAttachments($message);
                $message->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->id) .' '.
            Str::plural('message', count($request->id)).'.');

        return redirect()->route('admin_messages');
    }
}
