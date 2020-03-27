<?php

namespace App\Listeners;

use App\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HookSocial
{
    /**
     * Handle the event.
     *
     * @param Authenticated $event
     * @return void
     */

    public function handle(Registered $event)
    {
        if (empty($event->data['social']))
            return;

        $social = \App\Social::where('slug', $event->data['social'])->first();

        $usersocial = new \App\Usersocial;
        $usersocial->user_id = $event->data['user_id'];
        $usersocial->social_id = $social->id;
        $usersocial->account = $event->data['socialaccount_id'];
        $usersocial->save();
    }
}
