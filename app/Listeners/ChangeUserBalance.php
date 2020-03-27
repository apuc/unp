<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class ChangeUserBalance
{
    public function handle($event)
    {
        if ($event instanceof \App\Events\ForecastCreated)
            $this->update($event->forecast->user);

        elseif ($event instanceof \App\Events\ForecastUpdated) {
            $this->update($event->forecast->user);

            if ($event->forecast->user_id != $event->old->user_id)
                $this->update($event->old->user);
        } elseif ($event instanceof \App\Events\ForecastDestroy)
            $this->update($event->forecast->user, $event->forecast->id);
    }

    private function update($user, $id = null)
    {
        $win = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("SUM(forecasts.rate * forecasts.bet) as `sum`")
                ->where('forecasts.user_id', $user->id)
                ->whereExists(function ($query) {
                    $query
                        ->select('forecaststatuses.id')
                        ->from('forecaststatuses')
                        ->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
                        ->where('forecaststatuses.slug', 'win');
                });

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->sum;
        });

        $lose = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("SUM(forecasts.rate * forecasts.bet) as `sum`")
                ->where('forecasts.user_id', $user->id)
                ->whereExists(function ($query) {
                    $query
                        ->select('forecaststatuses.id')
                        ->from('forecaststatuses')
                        ->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
                        ->where('forecaststatuses.slug', 'lose');
                });

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->sum;
        });

        $user->balance = config('register.bonus') + $win - $lose;
        $user->save();
    }
}
