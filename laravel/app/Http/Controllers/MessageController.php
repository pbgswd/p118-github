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

    public function update(Request $request, Message $message, User $user, MessageSelections $messageSelections): RedirectResponse
    {
//todo form request validator
//todo make a policy

        MessageController:: updateMessageFrequencyPreferences($request, $user);
        MessageController::updateTopicSubscriptions($user, $request['message_selections']['topic']);

        MessageController::updateModelSubscriptions($user, $request['message_selections']['model']);

        MessageController::updateCommitteeSubscriptions($user, $request['message_selections']['committee']);


        //todo how to compare
        $topics = Options::message_subscription_options();

        foreach($topics as $t) {
            $arr[] = $t['slug'];
        }
        $array_to_delete = array_diff($arr,  $request->topic_selections);
        foreach($array_to_delete as $atd)
        {
            MessageSelections::where('user_id', $user->id)->where('name', $atd)->delete();
        }


        //todo save only new things checked
        $array_to_save = array_intersect($arr, $request->topic_selections);
        foreach($array_to_save as $ats)
        {
            $messageSelections->fill(['user_id' => $user->id, 'type' => 'topic', 'name' => $ats]);
            $messageSelections->save();
        }


        $committees = Committee::where('live', '=', 1)->pluck('name', 'slug')->toArray();

        //dd([$topics, $committees]);

        //todo create prefs And selections rows
        //todo save, update selections multiple selections

        // $request['topic_selections']
        // $request['committee_selections']

        Session::flash('success', 'Your message preferences have been updated');

        return redirect()->route('member', $user->id);
    }

    public function updateMessageFrequencyPreferences($request, $user): bool
    {

        if ($user->message_frequency_preferences instanceof MessageFrequencyPreferences) {
            $user->message_frequency_preferences->fill(['preference' => $request['preference']]);
            $user->message_frequency_preferences->save();
        } else {
            $preferences = new MessageFrequencyPreferences(['preference' => $request['preference']]);
            $user->message_frequency_preferences->save($preferences);
        }
        return true;
    }

    public function updateModelSubscriptions(User $user, $sub) : bool
    {
       // dd([$sub, $user->id]);

        MessageSelection::where('user', '=', $user->id)->delete();
        //delete subscriptions
        return true;
        // insert subscriptions
    }

    public function updateTopicSubscriptions(User $user,$sub): bool
    {
        dd($sub);
        //delete subscriptions

        // insert subscriptions
        return true;
    }

    public function updateCommitteeSubscriptions(User $user,$sub): bool
    {
        dd($sub);
        //delete subscriptions

        // insert subscriptions
        return true;
    }
}
