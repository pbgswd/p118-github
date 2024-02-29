<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Message;
use App\Models\MessageFrequencyPreferences;
use App\Models\MessageSelection;
use App\Models\MessageSelections;
use App\Models\Options;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function GuzzleHttp\Promise\queue;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //todo not used
        $data = [];
        return view('messages', ['data' => $data]);
    }

    /**
     * @param Message $message
     * @return View
     */
    public function show(Message $message): View
    {
        // todo not used
        $data = [];
        return view('message', ['data' => $data]);
    }

    public function update(Request $request, Message $message, User $user, MessageSelection $messageSelection): RedirectResponse
    {
//todo form request validator
//todo make a policy

        self::updateMessageFrequencyPreferences($request, $user);
//dd( $request['message_selections']);
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
        } else {
            $preferences = new MessageFrequencyPreferences(['preference' => $request['preference']]);
            $user->message_frequency_preferences->save($preferences);
        }
    }

    public static function updateModelSubscriptions(User $user, $sub) : void
    {
        $type = 'model';

        MessageSelection::where([
            ['user_id', '=', $user->id],
            ['type', '=', $type ]
        ])->delete();

        foreach($sub as $s)
        {
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
            ['type', '=', $type ]
        ])->delete();

        foreach($sub as $s)
        {
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
            ['type', '=', $type ]
        ])->delete();

        foreach($sub as $s)
        {
            $ms = new MessageSelection;
            $ms->user_id = $user->id;
            $ms->type = $type;
            $ms->name = $s;
            $ms->save();
        }
    }
}
