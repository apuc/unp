<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class UpdateForecastStat
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */

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
        // кол-во прогнозов
        $this->updateCount($user, $id);

        // профит
        $this->updateProfitAndRoi($user, $id);

        // побед
        $this->updateWin($user, $id);

        // поражений
        $this->updateLosses($user, $id);

        // возвратов
        $this->updateDraws($user, $id);

        // средний коэффициент
        $this->updateOffer($user, $id);

        // средняя ставка
        $this->updateBet($user, $id);

        // процент удачи
        $this->updateLuck($user);

        $user->save();
    }

    private function updateCount($user, $id = null)
    {
        $user->stat_forecasts = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("COUNT(*) as `forecasts_count`")
                ->where('forecasts.user_id', $user->id);

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->forecasts_count;
        });
    }

    private function updateProfitAndRoi($user, $id = null)
    {
        $win = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("SUM(forecasts.rate * forecasts.bet - forecasts.bet) as `sum`")
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
                ->selectRaw("SUM(forecasts.bet) as `sum`")
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

        $balance = config('register.bonus') + $win - $lose;

        $user->stat_profit = $balance * 100 / config('register.bonus');
    }

    private function updateWin($user, $id = null)
    {
        $user->stat_wins = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("COUNT(`forecasts`.`id`) as `forecasts_count`")
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

            return $query->first()->forecasts_count;
        });
    }

    private function updateLosses($user, $id = null)
    {
        $user->stat_losses = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("COUNT(`forecasts`.`id`) as `forecasts_count`")
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

            return $query->first()->forecasts_count;
        });
    }

    private function updateDraws($user, $id = null)
    {
        $user->stat_draws = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("COUNT(`forecasts`.`id`) as `forecasts_count`")
                ->where('forecasts.user_id', $user->id)
                ->whereExists(function ($query) {
                    $query
                        ->select('forecaststatuses.id')
                        ->from('forecaststatuses')
                        ->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
                        ->where('forecaststatuses.slug', 'draw');
                });

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->forecasts_count;
        });
    }

    private function updateOffer($user, $id = null)
    {
        $user->stat_offer = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("AVG(`forecasts`.`rate`) as `odds_avg`")
                ->where('forecasts.user_id', $user->id)
                ->whereExists(function ($query) {
                    $query
                        ->select('forecaststatuses.id')
                        ->from('forecaststatuses')
                        ->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
                        ->whereIn('forecaststatuses.slug', ['win', 'lose', 'draw']);
                });

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->odds_avg;
        });
    }

    private function updateBet($user, $id = null)
    {
        $user->stat_bet = call_user_func(function () use ($user, $id) {
            $query = DB::table('forecasts')
                ->selectRaw("AVG(`forecasts`.`bet`) as `bet_avg`")
                ->where('forecasts.user_id', $user->id)
                ->whereExists(function ($query) {
                    $query
                        ->select('forecaststatuses.id')
                        ->from('forecaststatuses')
                        ->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
                        ->whereIn('forecaststatuses.slug', ['win', 'lose', 'draw']);
                });

            if (! empty($id))
                $query->where('forecasts.id', '<>', $id);

            return $query->first()->bet_avg;
        });
    }

    private function updateLuck($user)
    {
        $all = ($user->stat_wins + $user->stat_losses + $user->stat_draws);

        $user->stat_luck = $all > 0 ? ($user->stat_wins * 100 / $all) : 0;
    }
}
