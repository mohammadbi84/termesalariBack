<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\VerifyEmail;

class SendWelcomeMail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = [
            'name' => $event->user->name,
            'family' => $event->user->family,
            'mobile' => $event->user->mobile
        ];
        if ($event->user->email != "") {
            Mail::to($event->user->email)
            ->send(new VerifyEmail($data));
        }
        
    }
}
