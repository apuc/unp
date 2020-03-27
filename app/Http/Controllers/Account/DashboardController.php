<?php

namespace App\Http\Controllers\Account;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Auth;
use Facades\App\Http\Handlers\ProfitHandler;

class DashboardController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		$forecast	= $this->forecast();
		$post		= $this->post();
		$brief		= $this->brief();
		$years		= $this->years();

		return view($this->view, compact(
			'forecast',
			'post',
			'brief',
			'years'
		));
	}

	/**
	 *
	 *
	 */

	public function profit(Request $request)
	{
		$profits = ProfitHandler::getByYear($request->year);

		return view($this->view, compact(
			'profits'
		));
	}

	/**
	 *
	 *
	 */

	private function years()
	{
		return DB::table('forecasts')
			->selectRaw("DATE_FORMAT(posted_at, '%Y') as `value`")
			->where('user_id', Auth::user()->id)
			->orderBy('value', 'desc')
			->groupBy('value')
			->get();
	}

	/**
	 *
	 *
	 */

	private function brief()
	{
		return DB::table('briefs')
			// всего
			->selectRaw(call_user_func(function () {
				$query = DB::table('briefs')
					->selectRaw("COUNT(*) as `briefs_count`")
					->where('briefs.user_id', "?")
				;

				return "({$query->toSql()}) as all_count";
			}), [Auth::user()->id])

			// опубликованных
			->selectRaw(call_user_func(function () {
				$query = DB::table("briefs")
					->selectRaw("COUNT(*) as `briefs_count`")
					->where("briefs.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("briefstatuses.id")
							->from("briefstatuses")
							->whereColumn("briefs.briefstatus_id", "briefstatuses.id")
							->where("briefstatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as confirmed_count";
			}), [Auth::user()->id, 'confirmed'])

			// отклоннено
			->selectRaw(call_user_func(function () {
				$query = DB::table("briefs")
					->selectRaw("COUNT(*) as `briefs_count`")
					->where("briefs.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("briefstatuses.id")
							->from("briefstatuses")
							->whereColumn("briefs.briefstatus_id", "briefstatuses.id")
							->where("briefstatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as declined_count";
			}), [Auth::user()->id, 'declined'])

			// черновиков
			->selectRaw(call_user_func(function () {
				$query = DB::table("briefs")
					->selectRaw("COUNT(*) as `briefs_count`")
					->where("briefs.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("briefstatuses.id")
							->from("briefstatuses")
							->whereColumn("briefs.briefstatus_id", "briefstatuses.id")
							->where("briefstatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as draft_count";
			}), [Auth::user()->id, 'draft'])

			->first()
		;
	}

	/**
	 *
	 *
	 */

	private function post()
	{
		return DB::table('posts')
			// всего
			->selectRaw(call_user_func(function () {
				$query = DB::table('posts')
					->selectRaw("COUNT(*) as `posts_count`")
					->where('posts.user_id', "?")
				;

				return "({$query->toSql()}) as all_count";
			}), [Auth::user()->id])

			// опубликованных
			->selectRaw(call_user_func(function () {
				$query = DB::table("posts")
					->selectRaw("COUNT(*) as `posts_count`")
					->where("posts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("poststatuses.id")
							->from("poststatuses")
							->whereColumn("posts.poststatus_id", "poststatuses.id")
							->where("poststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as confirmed_count";
			}), [Auth::user()->id, 'confirmed'])

			// отклоннено
			->selectRaw(call_user_func(function () {
				$query = DB::table("posts")
					->selectRaw("COUNT(*) as `posts_count`")
					->where("posts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("poststatuses.id")
							->from("poststatuses")
							->whereColumn("posts.poststatus_id", "poststatuses.id")
							->where("poststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as declined_count";
			}), [Auth::user()->id, 'declined'])

			// черновиков
			->selectRaw(call_user_func(function () {
				$query = DB::table("posts")
					->selectRaw("COUNT(*) as `posts_count`")
					->where("posts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("poststatuses.id")
							->from("poststatuses")
							->whereColumn("posts.poststatus_id", "poststatuses.id")
							->where("poststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as draft_count";
			}), [Auth::user()->id, 'draft'])

			->first()
		;
	}

	/**
	 *
	 *
	 */

	private function forecast()
	{
		return DB::table('forecasts')
			// всего
			->selectRaw(call_user_func(function () {
				$query = DB::table('forecasts')
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where('forecasts.user_id', "?")
				;

				return "({$query->toSql()}) as all_count";
			}), [Auth::user()->id])

			// новых
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("forecaststatuses.id")
							->from("forecaststatuses")
							->whereColumn("forecasts.forecaststatus_id", "forecaststatuses.id")
							->whereIn("forecaststatuses.slug", ['?', '?'])
						;
					})
				;

				return "({$query->toSql()}) as new_count";
			}), [Auth::user()->id, 'checking', 'confirmed'])

			// выйграло
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("forecaststatuses.id")
							->from("forecaststatuses")
							->whereColumn("forecasts.forecaststatus_id", "forecaststatuses.id")
							->where("forecaststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as win_count";
			}), [Auth::user()->id, 'win'])

			// проиграло
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("forecaststatuses.id")
							->from("forecaststatuses")
							->whereColumn("forecasts.forecaststatus_id", "forecaststatuses.id")
							->where("forecaststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as lose_count";
			}), [Auth::user()->id, 'lose'])

			// отклонено
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("forecaststatuses.id")
							->from("forecaststatuses")
							->whereColumn("forecasts.forecaststatus_id", "forecaststatuses.id")
							->where("forecaststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as declined_count";
			}), [Auth::user()->id, 'declined'])

			// черновиков
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("COUNT(*) as `forecasts_count`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select("forecaststatuses.id")
							->from("forecaststatuses")
							->whereColumn("forecasts.forecaststatus_id", "forecaststatuses.id")
							->where("forecaststatuses.slug", "?")
						;
					})
				;

				return "({$query->toSql()}) as draft_count";
			}), [Auth::user()->id, 'draft'])

			// ср коэф
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("AVG(`forecasts`.`rate`) as `odds_avg`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select('forecaststatuses.id')
							->from('forecaststatuses')
							->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
							->whereIn('forecaststatuses.slug', ['?', '?', '?']);
						;
					})
				;

				return "({$query->toSql()}) as odds_avg";
			}), [Auth::user()->id, 'win', 'lose', 'draw'])

			// ср ставка.
			->selectRaw(call_user_func(function () {
				$query = DB::table("forecasts")
					->selectRaw("AVG(`forecasts`.`bet`) as `bet_avg`")
					->where("forecasts.user_id", "?")
					->whereExists(function ($query) {
						$query
							->select('forecaststatuses.id')
							->from('forecaststatuses')
							->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
							->whereIn('forecaststatuses.slug', ['?', '?', '?']);
						;
					})
				;

				return "({$query->toSql()}) as bet_avg";
			}), [Auth::user()->id, 'win', 'lose', 'draw'])

			//->toSql()
			->first()
		;
	}
}
