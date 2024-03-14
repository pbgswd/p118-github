<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;


class SendEmailsNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queued messages to subscribers who want messages right away.';

    /**
     * @return int
     */
    public function handle(): int
    {
       //todo select messages in queue, lined up with messages ready to go out

        $messages = Message::where('sent', '=', 'send')->get();

        //users that want the message now.
        $subscribers = User::with('message_frequency_preferences', 'message_selections')
            ->whereRelation('message_frequency_preferences', 'preference', '=', 'now')
            ->get();

        foreach($messages as $message)
        {
            echo "type: " .$message->type . ", name: " . $message->name ."\n";

            foreach($subscribers as $sub)
            {
                echo $sub->email ."\n";
                // has subscriber been sent the message already?
                // insert into mail queue the $message with the email address for $sub
            }



        }

        //invoke mail sending service, send them out

        //delete the rows just mailed out

        Log::info('SendEmailsNow has run at ' . date('l jS \of F Y h:i:s A'));

        return Command::SUCCESS;
    }
}
