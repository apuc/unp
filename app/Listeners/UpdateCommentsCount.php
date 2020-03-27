<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateCommentsCount
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */

    public function handle($event)
    {
        // прогнозы
        if ($event instanceof \App\Events\ForecastcommentCreated)
            $this->update($event->forecastcomment->user, 'forecastcomments');

        elseif ($event instanceof \App\Events\ForecastcommentUpdated) {
            $this->update($event->forecastcomment->user, 'forecastcomments');

            if ($event->forecastcomment->user_id != $event->old->user_id)
                $this->update($event->old->user, 'forecastcomments');
        } elseif ($event instanceof \App\Events\ForecastcommentDestroy)
            $this->update($event->forecastcomment->user, 'forecastcomments', $event->forecastcomment->id);


        // статьи
        elseif ($event instanceof \App\Events\PostcommentCreated)
            $this->update($event->postcomment->user, 'postcomments');

        elseif ($event instanceof \App\Events\PostcommentUpdated) {
            $this->update($event->postcomment->user, 'postcomments');

            if ($event->postcomment->user_id != $event->old->user_id)
                $this->update($event->old->user, 'postcomments');
        } elseif ($event instanceof \App\Events\PostcommentDestroy)
            $this->update($event->postcomment->user, 'postcomments', $event->postcomment->id);


        // новости
        elseif ($event instanceof \App\Events\BriefcommentCreated)
            $this->update($event->briefcomment->user, 'briefcomments');

        elseif ($event instanceof \App\Events\BriefcommentUpdated) {
            $this->update($event->briefcomment->user, 'briefcomments');

            if ($event->briefcomment->user_id != $event->old->user_id)
                $this->update($event->old->user, 'briefcomments');
        } elseif ($event instanceof \App\Events\BriefcommentDestroy)
            $this->update($event->briefcomment->user, 'briefcomments', $event->briefcomment->id);
    }

    private function update($user, $table, $id = null)
    {
        $postcomments = $this->getComments($user, 'postcomments', ($table == 'postcomments' ? $id : null));
        $briefcomments = $this->getComments($user, 'briefcomments', ($table == 'briefcomments' ? $id : null));
        $forecastcomments = $this->getComments($user, 'forecastcomments', ($table == 'forecastcomments' ? $id : null));

        $user->stat_comments = $postcomments + $briefcomments + $forecastcomments;
        $user->save();
    }

    private function getComments($user, $table, $id = null)
    {
        $query = DB::table("{$table}")
            ->selectRaw("COUNT(`{$table}`.`id`) as comments_count")
            ->whereExists(function ($query) use ($table) {
                $query
                    ->select("commentstatuses.id")
                    ->from("commentstatuses")
                    ->whereColumn("{$table}.commentstatus_id", "commentstatuses.id")
                    ->where("commentstatuses.slug", '<>', "declined");
            })
            ->where("{$table}.user_id", $user->id);

        if (! empty($id))
            $query->where("{$table}.id", '<>', $id);

        return $query->first()->comments_count;
    }
}
