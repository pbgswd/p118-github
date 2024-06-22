<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Message;
use App\Models\MessageFrequencyPreferences;
use App\Models\MessageSelection;
use App\Models\Options;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //todo where send_status_now != 'no'
        $messages = Message::sortable()
            ->with('user', 'attachments', 'messageMeta', 'messageSending')
            ->whereRelation('messageSending', 'send_status_now', '!=', 'no')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $data = [
            'messages' => $messages,
            'count' => Message::with('messageSending')->whereRelation('messageSending', 'send_status_now', '!=', 'no')->count(),
        ];

        return view('messages', ['data' => $data]);
    }

    public function show(Message $message): View
    {
        $message->load('user', 'attachments', 'messageMeta', 'messageSending');

        //todo distinguish between types and pull in the data
        $committee = [];
        $model = [];
        $topic = [];

        $modelSubOptions = Options::model_subscription_options();

        switch ($message->type) {
            case 'model':
                $modelSubOptions = Options::model_subscription_options();

                $row = array_search($message->name, array_column($modelSubOptions, 'model'));

                $class = 'App\\Models\\'.$message->name;

                //dd(['class' => $message->name, 'key' => $modelSubOptions[$row]['key']]);
                //key will be slug or  id
                $model = $class::where($modelSubOptions[$row]['key'], '=', $message->slug)->first();

                break;
            case 'topic':
                //todo differentiate between a page or post
                //we have nothing that gets page or post though we can have a data relation, source_url var for data pushed in to Messages model data
                $topic = Topic::where('slug', $message->name)->first();
                //   dd($topic[0]);
                break;
            case 'committee':
                $committee = Committee::where('slug', $message->name)->first();
                break;
            default:
                $committee = [];
                $model = [];
                $topic = [];
                break;
        }
        //dd([$message, $committee, $model, $topic]);

        $data = [
            'message' => $message,
        ];

        //  dd($data['message']->attachments);

        return view('message', ['data' => $data]);
    }

    public function update(Request $request, Message $message, User $user, MessageSelection $messageSelection): RedirectResponse
    {
        //todo form request validator
        //todo make a policy for this user, only this user

        self::updateMessageFrequencyPreferences($request, $user);

        self::updateTopicSubscriptions($user, $request['message_selections']['topic'] ?? []);

        self::updateModelSubscriptions($user, $request['message_selections']['model'] ?? []);

        self::updateCommitteeSubscriptions($user, $request['message_selections']['committee'] ?? []);

        Session::flash('success', 'Your message preferences have been updated');

        return redirect()->route('member', $user->id);
    }

    public static function updateMessageFrequencyPreferences($request, $user): void
    {
        if ($user->message_frequency_preferences instanceof MessageFrequencyPreferences) {
            $user->message_frequency_preferences->fill(['preference' => $request['preference']]);
            $user->message_frequency_preferences->save();

            if ($request['preference'] == 'unsubscribe') {
                MessageSelection::where('user_id', $user->id)->delete();
                MessageFrequencyPreferences::where('user_id', $user->id)->delete();
            }
        } else {
            $preferences = new MessageFrequencyPreferences(['preference' => $request['preference']]);
            $user->message_frequency_preferences->save($preferences);
        }
    }

    public static function updateModelSubscriptions(User $user, $sub): void
    {
        $type = 'model';

        MessageSelection::where([
            ['user_id', '=', $user->id],
            ['type', '=', $type],
        ])->delete();

        foreach ($sub as $s) {
            $ms = new MessageSelection;
            $ms->user_id = $user->id;
            $ms->type = $type;
            $ms->name = $s;
            $ms->save();
        }
    }

    public static function updateTopicSubscriptions(User $user, $sub): void
    {
        $type = 'topic';

        MessageSelection::where([
            ['user_id', '=', $user->id],
            ['type', '=', $type],
        ])->delete();

        foreach ($sub as $s) {
            $ms = new MessageSelection;
            $ms->user_id = $user->id;
            $ms->type = $type;
            $ms->name = $s;
            $ms->save();
        }
    }

    public static function updateCommitteeSubscriptions(User $user, $sub): void
    {

        $type = 'committee';

        MessageSelection::where([
            ['user_id', '=', $user->id],
            ['type', '=', $type],
        ])->delete();

        foreach ($sub as $s) {
            $ms = new MessageSelection;
            $ms->user_id = $user->id;
            $ms->type = $type;
            $ms->name = $s;
            $ms->save();
        }
    }
}
