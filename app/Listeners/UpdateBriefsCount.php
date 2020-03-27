<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateBriefsCount
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */

    public function handle($event)
    {
        if ($event instanceof \App\Events\BriefCreated)
            $this->update($event->brief->user);

        elseif ($event instanceof \App\Events\BriefUpdated) {
            $this->update($event->brief->user);

            if ($event->brief->user_id != $event->old->user_id)
                $this->update($event->old->user);
        } elseif ($event instanceof \App\Events\BriefDestroy)
            $this->update($event->brief->user, $event->brief->id);
    }

    private function update($user, $id = null)
    {
        $user->stat_briefs = call_user_func(function () use ($user, $id) {
            $query = DB::table('briefs')
                ->selectRaw("COUNT(*) as `briefs_count`")
                ->where('briefs.user_id', $user->id);

            if (! empty($id))
                $query->where('briefs.id', '<>', $id);

            return $query->first()->briefs_count;
        });

        $user->save();
    }
}
