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
     */
    public function index(): View
    {
        //todo where send_status_now != 'no'
        $messages = Message::sortable()
            ->with('user', 'attachments')
            ->where('state', '!=', 'not_sent')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $data = [
            'messages' => $messages,
            'count' => Message::where('state', '!=', 'not_sent')->count(),
        ];

        return view('messages', ['data' => $data]);
    }

    public function show(Message $message): View
    {
        $message->load('user', 'attachments');

        //todo prove pagination works

        $next = Message::where('updated_at', '>', $message->updated_at)
            ->where ('state', 'sent')
            ->orderBy('updated_at', 'asc')
            ->first();

        $previous = Message::where('updated_at', '<', $message->updated_at)
            ->where ('state', 'sent')
            ->orderBy('updated_at', 'desc')
            ->first();

        $data = [
            'message' => $message,
            'next' => $next,
            'previous' => $previous,
        ];

        return view('message', ['data' => $data]);
    }

    public function update(Request $request, Message $message, User $user, MessageSelection $messageSelection): RedirectResponse
    {
        //todo form request validator
        //todo make a policy for this user, only this user

        //self::updateMessageFrequencyPreferences($request, $user);

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
//todo form request validator

        $type = 'committee';

        MessageSelection::where([
            ['user_id', '=', $user->id],
            ['type', '=', $type],
        ])->delete();

        //todo write closure / anonymous function
        foreach ($sub as $s) {
            $ms = new MessageSelection;
            $ms->user_id = $user->id;
            $ms->type = $type;
            $ms->name = $s;
            $ms->save();
        }
    }
}
