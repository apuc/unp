<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordForClient
{
    /**
     * Handle the event.
     *
     * @param Authenticated $event
     * @return void
     */

    public function handle(Registered $event)
    {
        Mail::to([$event->data['email']])->queue(new \App\Mail\RegistrationSent($event->data));
    }
}
