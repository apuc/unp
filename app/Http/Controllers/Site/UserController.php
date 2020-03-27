<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;
use Carbon\Carbon;
use Userparameter;
use Facades\App\Http\Handlers\ProfitHandler;

class UserController extends Controller
{
	/**
	 *
	 *
	 *
	 */

	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('users')
			->first()
		;

		$users['view'] = Userparameter::get('v', 0);

		$users['rows'] = \App\User::query()
			->select('users.*')
			->withCount([
				'forecasts' => function ($query) {
					$query->whereHas('forecaststatus', function ($query) {
						$query->where('slug', 'checked');
					});
				}
			])
			->where('users.stat_forecasts', '>', 0)
			->orderBy(
				$users['sort'] = call_user_func(function () {
					switch(Userparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'users.stat_profit';

						case 1:
							return 'users.stat_roi';

						case 2:
							return 'users.stat_forecasts';

						case 3:
							return 'users.stat_wins';

						case 4:
							return 'users.stat_losses';

						case 5:
							return 'users.stat_draws';

						case 6:
							return 'users.stat_offer';

						/*
						case 7:
							return 'users.stat_bet';
						*/

						case 8:
							return 'users.stat_luck';

						case 9:
							return 'users.balance';
					}
				}),
				'desc'
			)
			->paginate($users['rc'] = call_user_func(function () {
				switch(Userparameter::get('rc')) {
					case null:
						return config('interface.users');

					default:
						return Userparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'users'
		));
	}

	/**
	 *
	 *
	 */

	public function show($login)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('users')
			->first()
		;

		$user = \App\User::query()
			->select('users.*')
			->with([
				'forecasts' => function ($query) use ($login) {
					$query
						->select('forecasts.*')
						->with([
							'sport',
							'outcometype',
							'outcomescope',
							'outcomesubtype',
							'bookmaker',
							'user',
							'team',
							'forecaststatus',
							'match.stage.season.tournament',
							'match.participants' => function ($query) {
								$query
									->orderBy('position', 'asc')
								;
							},
							'match.participants.team',
						])
						->withCount([
							'forecastcomments' => function ($query) {
								$query->whereHas('commentstatus', function ($query) {
									$query->whereNotIn('slug', ['declined']);
								});
							}
						])
						->whereHas('forecaststatus', function ($query) {
							$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
						})
						->whereHas('match.participants', function ($query) {
							$query->skip(1)->take(1);
						})
						->whereHas('user', function ($query) use ($login) {
							$query->where('login', $login);
						})
						//->whereNotNull('forecasts.description')
						->orderBy('forecasts.posted_at', 'desc')
						->take(3)
					;
				},
				'posts' => function ($query) {
					$query
						->select('posts.*')
						->with([
							'user',
							'sport',
						])
						->withCount([
							'postcomments' => function ($query) {
								$query->whereHas('commentstatus', function ($query) {
									$query->whereNotIn('slug', ['declined']);
								});
							}
						])
						->whereHas('poststatus', function ($query) {
							$query->where('slug', 'confirmed');
						})
						->where('posted_at', '<=', Carbon::now()->toDateTimeString())
						->sortBy('posted_at', 'desc')
						->take(3)
					;
				},
				'briefs' => function ($query) {
					$query
						->select('briefs.*')
						->with([
							'user',
							'sport',
						])
						->withCount([
							'briefcomments' => function ($query) {
								$query->whereHas('commentstatus', function ($query) {
									$query->whereNotIn('slug', ['declined']);
								});
							}
						])
						->whereHas('briefstatus', function ($query) {
							$query->where('slug', 'confirmed');
						})
						->where('posted_at', '<=', Carbon::now()->toDateTimeString())
						->sortBy('posted_at', 'desc')
						->take(3)
					;
				},
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->where('slug', 'checked');
					});
				},
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->where('slug', 'checked');
					});
				},
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->where('slug', 'checked');
					});
				}
			])
			->where('login', $login)
			->firstOrFail()
		;

		$profits = ProfitHandler::getLast($user->id);

		Crumb::set('name', $user->login);
		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	trans('seo.site.user', [
			'login'				=> $user->nickname,
			'created_at'		=> \Moment::asDate($user->created_at),
			'stat_forecasts'	=> $user->stat_forecasts,
			'stat_comments'		=> $user->stat_comments,
			'balance'			=> $user->balance,
			'stat_briefs'		=> $user->stat_briefs,
			'stat_posts'		=> $user->stat_posts,
		]));
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		if (null !== $user->avatar) {
			Crumb::set('og_image',			asset('/preview/100/100/storage/users/' . $user->avatar));
			Crumb::set('og_image_width',	'100');
			Crumb::set('og_image_height',	'100');
		}

		return view($this->view, compact(
			'user',
			'profits'
		));
	}
}
