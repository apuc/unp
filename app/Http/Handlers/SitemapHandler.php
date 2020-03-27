<?php

namespace App\Http\Handlers;

use Siteset\Sitemap\Handler;
use Siteset\Sitemap\Node;
use URI;

class SitemapHandler extends Handler
{
	/**
	 *
	 * @param collect $collect
	 */

	public function siteHomeIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.home.index');
		$node->loc			= route('site.home.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteBriefIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.brief.index');
		$node->loc			= route('site.brief.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}


	/**
	 *
	 *
	 * @param collect $collect
	 */

	public function siteBriefShow($collect)
	{
		$briefs = \App\Brief::query()
			->select('briefs.*')
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->sortBy('posted_at', 'desc')
			->get()
		;

		foreach ($briefs as $brief) {
			$node = new Node();
			$node->name		= $brief->name;
			$node->loc		= route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)]);
			$node->lastmod	= $brief->posted_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function sitePostIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.post.index');
		$node->loc			= route('site.post.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}


	/**
	 *
	 *
	 * @param collect $collect
	 */

	public function sitePostShow($collect)
	{
		$posts = \App\Post::query()
			->select('posts.*')
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->sortBy('posted_at', 'desc')
			->get()
		;

		foreach ($posts as $post) {
			$node = new Node();
			$node->name		= $post->name;
			$node->loc		= route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)]);
			$node->lastmod	= $post->posted_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteForecastIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.forecast.index');
		$node->loc			= route('site.forecast.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}


	/**
	 *
	 *
	 * @param collect $collect
	 */

	public function siteForecastShow($collect)
	{
		$forecasts = \App\Forecast::query()
			->select('forecasts.*')
			->with([
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'bookmaker',
				'user',
				'match.participants' => function ($query) {
					$query
						->orderBy('position', 'asc')
					;
				},
				'match.participants.team',
			])
			->leftJoin('matches', 'forecasts.match_id', '=', 'matches.id')
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->whereNotNull('forecasts.description')
			->orderBy('matches.started_at', 'desc')
			->get()
		;

		foreach ($forecasts as $forecast) {
			$node = new Node();
			$node->name		= trans('option.site.forecast', [
				'team1'				=> $forecast->match->participants[0]->team->name,
				'team2'				=> $forecast->match->participants[1]->team->name,
				'outcometype'		=> $forecast->outcometype->name,
				'outcomescope'		=> $forecast->outcomescope->name,
				'outcomesubtype'	=> $forecast->outcomesubtype->name,
				'user'				=> $forecast->user->nickname,
			]);
			$node->loc		= route('site.forecast.show', ['forecast' => $forecast->id]);
			$node->lastmod	= $forecast->posted_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteBookmakerIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.bookmaker.index');
		$node->loc			= route('site.bookmaker.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteBookmakerShow($collect)
	{
		$bookmakers = \App\Bookmaker::query()
			->select('bookmakers.*')
			->where('is_enabled', 1)
			->sortBy('name', 'asc')
			->get()
		;

		foreach ($bookmakers as $bookmaker) {
			$node = new Node();
			$node->name		= $bookmaker->name;
			$node->loc		= route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]);
			$node->lastmod	= $bookmaker->updated_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteDealIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.deal.index');
		$node->loc			= route('site.deal.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteDealShow($collect)
	{
		$deals = \App\Deal::query()
			->select('deals.*')
			->get()
		;

		foreach ($deals as $deal) {
			$node = new Node();
			$node->name		= $deal->name;
			$node->loc		= route('site.deal.show', ['deal' => $deal->id]);
			$node->lastmod	= $deal->updated_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteUserIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.user.index');
		$node->loc			= route('site.user.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteUserShow($collect)
	{
		$users = \App\User::query()
			->select('users.*')
			->sortBy('login', 'asc')
			->get()
		;

		foreach ($users as $user) {
			$node = new Node();
			$node->name		= $user->nickname;
			$node->loc		= route('site.user.show', ['login' => $user->login]);
			$node->lastmod	= $user->updated_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteMatchIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.match.index');
		$node->loc			= route('site.match.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteHelpIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.help.index');
		$node->loc			= route('site.help.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteHelpSection($collect)
	{
		$helpsections = \App\Helpsection::query()
			->select('helpsections.*')
			->sortBy('name')
			->get()
		;

		foreach ($helpsections as $helpsection) {
			$node = new Node();
			$node->name		= $helpsection->name;
			$node->loc		= route('site.help.section', ['section' => $helpsection->slug]);
			$node->lastmod	= $helpsection->updated_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteLegalIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.legal.index');
		$node->loc			= route('site.legal.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteLegalShow($collect)
	{
		$legaldocuments = \App\Legaldocument::query()
			->selectRaw('legaldocuments.*, (SELECT MAX(issued_at) FROM legaleditions WHERE legaldocuments.id = legaleditions.legaldocument_id) issued_at')
			->orderBy('position', 'asc')
			->get()
			->reject(function ($legaldocument) {
				return $legaldocument->issued_at === null;
			})
		;

		foreach ($legaldocuments as $legaldocument) {
			$node = new Node();
			$node->name		= $legaldocument->name;
			$node->loc		= route('site.legal.show', ['document' => $legaldocument->slug]);
			$node->lastmod	= $legaldocument->issued_at;

			$collect->push($node);
		}
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteAboutIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.about.index');
		$node->loc			= route('site.about.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteContactIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.contact.index');
		$node->loc			= route('site.contact.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}

	/**
	 *
	 * @param collect $collect
	 */

	public function siteSitemapIndex($collect)
	{
		$node = new Node();
		$node->name			= trans('page.site.sitemap.index');
		$node->loc			= route('site.sitemap.index');
		$node->changefreq	= 'daily';
		$node->priority		= 100;

		$collect->push($node);
	}
}
