<?php

namespace App\Http\Handlers;

use Illuminate\Http\Request;
use Facades\App\Queries\Stat\User\CalcProfitQuery;
use Facades\App\Queries\Stat\User\CalcLuckQuery;
use Facades\App\Queries\Stat\User\CalcRoiQuery;
use Facades\App\Queries\Stat\User\CalcBalanceQuery;
use DB;
use \Carbon\Carbon;

class ProfitHandler
{
	/**
	 *
	 *
	 */

	private $user_id;

	/**
	 *
	 *
	 */

	public function getLast($user_id = null)
	{
		$this->user_id = $user_id ?? \Auth::user()->id;

		$months = call_user_func(function () {
			$months = collect();

			for ($m = 0; $m < config('interface.profits'); $m++)
				$months->push(
					now()->subMonth($m)->format('Y-m')
				);

			return $months;
		});

		$forecasts = \App\Forecast::query()
			->select('forecasts.*')
			->selectRaw("DATE_FORMAT(`posted_at`, '%Y-%m') as `month`")
			->with([
				'forecaststatus',
			])
			->where('user_id', $this->user_id)
			->where('posted_at', '>=', now()->subMonth(config('interface.profits'))->format('Y-m-d 00:00:00'))
			->orderBy('posted_at', 'desc')
			->get();

		return $this->calc($forecasts, $months);
	}

	/**
	 *
	 *
	 */

	public function getByYear($year, $user_id = null)
	{
		$this->user_id = $user_id ?? \Auth::user()->id;

		$months = call_user_func(function () use ($year) {
			$months	= collect();
			$count	= now()->format('Y') == $year ? (int)now()->format('m') : 12;

			for ($m = $count; $m > 0; $m--)
				$months->push(
					Carbon::parse($year . '-' . ((int)$m < 10 ? "0{$m}" : $m ) . '-01')->format('Y-m')
				);

			return $months;
		});

		$forecasts = \App\Forecast::query()
			->select('forecasts.*')
			->selectRaw("DATE_FORMAT(`posted_at`, '%Y-%m') as `month`")
			->with([
				'forecaststatus',
			])
			->where('user_id', $this->user_id)
			->where(function ($query) use ($months) {

				foreach ($months as $month)
					$query->orWhere('posted_at', 'like', "{$month}%");
			})
			->orderBy('posted_at', 'desc')
			->get();

		return $this->calc($forecasts, $months);
	}

	/**
	 *
	 *
	 */

	private function calc($forecasts, $months)
	{
		$dataset = collect();

		foreach ($months as $month) {
			$data = collect();

			foreach ($forecasts as $forecast)
				if ($forecast->month == $month)
					$data->push($forecast);

			$dataset->put($month, $data);
		}

		$result = collect();

		foreach ($dataset as $month => $data) {

			if ($data->count()) {
				// Подсчитать сумму всех завершенных ставок
				$bet = $data->filter(function ($forecast) {
					return in_array($forecast->forecaststatus->slug, ['win', 'lose', 'draw']);
				})->sum(function ($forecast) {
					return $forecast->bet;
				});

				// Подсчитать сумму победивших ставок
				$win = $data->filter(function ($forecast) {
					return $forecast->forecaststatus->slug == 'win';
				})->sum(function ($forecast) {
					return $forecast->rate * $forecast->bet - $forecast->bet;
				});

				// Подсчитать сумму проигравших ставок
				$lose = $data->filter(function ($forecast) {
					return $forecast->forecaststatus->slug == 'lose';
				})->sum(function ($forecast) {
					return $forecast->bet;
				});

				// Подсчитать количество прогнозов
				$forecasts = $data->count();

				// Подсчитать количество выигрывших прогнозов
				$wins = $data->filter(function ($forecast) {
					return $forecast->forecaststatus->slug == 'win';
				})->count();

				// Подсчитать количество проигравших прогнозов
				$losses = $data->filter(function ($forecast) {
					return $forecast->forecaststatus->slug == 'lose';
				})->count();

				// Подсчитать количество возвращенных прогнозов
				$draws = $data->filter(function ($forecast) {
					return $forecast->forecaststatus->slug == 'draw';
				})->count();

				// Подсчитать средний коэффициент ставок
				$offer = $data->filter(function ($forecast) {
					return in_array($forecast->forecaststatus->slug, ['win', 'lose', 'draw']);
				})->avg(function ($forecast) {
					return $forecast->rate;
				});

				$result->put($month, [
					'profit'	=> sprintf(
						"%0.02f",
						CalcProfitQuery::create()
							->where('start',	$this->balance($month))
							->where('bet',		$bet)
							->where('win',		$win)
							->where('lose',		$lose)
							->run()
					),
					'forecasts'	=> $forecasts,
					'wins'		=> $wins,
					'losess'	=> $losses,
					'draws'		=> $draws,
					'offer'		=> sprintf("%0.02f", $offer),
					'luck'		=> CalcLuckQuery::create()
						->where('wins',		$wins)
						->where('losses',	$losses)
						->where('draws',	$draws)
						->run(),
					'roi'		=> sprintf(
						"%0.02f",
						CalcRoiQuery::create()
							->where('bet', $bet)
							->where('win', $win)
							->run()
					),
				]);
			}
			else
				$result->put($month, null);
		}

		return $result;
	}

	/**
	 *
	 *
	 */

	private function balance($month)
	{
		$payments = (float)DB::table('payments')
			->selectRaw("SUM(`payments`.`amount`) as `sum`")
			->whereDate('payments.paid_at', '<', $month . '-01')
			->where('payments.user_id', $this->user_id)
			->first()
			->sum;

		$forecasts = \App\Forecast::query()
			->select('forecasts.*')
			->where('forecasts.user_id', $this->user_id)
			->whereHas('forecaststatus', function ($query) {
				$query->whereIn('forecaststatuses.slug', ['win', 'lose', 'confirmed']);
			})
			->whereDate('forecasts.posted_at', '<', $month . '-01')
			->get();

		// Подсчитать сумму победивших ставок
		$win = $forecasts->filter(function ($forecast) {
			return $forecast->forecaststatus->slug == 'win';
		})->sum(function ($forecast) {
			return $forecast->rate * $forecast->bet - $forecast->bet;
		});

		// Подсчитать сумму проигравших ставок
		$lose = $forecasts->filter(function ($forecast) {
			return $forecast->forecaststatus->slug == 'lose';
		})->sum(function ($forecast) {
			return $forecast->bet;
		});

		// Подсчитать сумму подтвержденных ставок
		$confirmed = $forecasts->filter(function ($forecast) {
			return $forecast->forecaststatus->slug == 'confirmed';
		})->sum(function ($forecast) {
			return $forecast->bet;
		});

		// Подсчитать баланс
		return CalcBalanceQuery::create()
			->where('start',		config('register.bonus'))
			->where('payments',		$payments)
			->where('win', 			$win)
			->where('lose',			$lose)
			->where('confirmed',	$confirmed)
			->run();
	}
}
