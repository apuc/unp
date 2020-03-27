<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdatePostsCount
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */

    public function handle($event)
    {
        if ($event instanceof \App\Events\PostCreated)
            $this->update($event->post->user);

        elseif ($event instanceof \App\Events\PostUpdated) {
            $this->update($event->post->user);

            if ($event->post->user_id != $event->old->user_id)
                $this->update($event->old->user);
        } elseif ($event instanceof \App\Events\PostDestroy)
            $this->update($event->post->user, $event->post->id);
    }

    private function update($user, $id = null)
    {
        $user->stat_posts = call_user_func(function () use ($user, $id) {
            $query = DB::table('posts')
                ->selectRaw("COUNT(*) as `posts_count`")
                ->where('posts.user_id', $user->id);

            if (! empty($id))
                $query->where('posts.id', '<>', $id);

            return $query->first()->posts_count;
        });

        $user->save();
    }
}
