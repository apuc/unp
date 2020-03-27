<?php

namespace App\Http\Controllers\Site;

use App\Sitesection;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;

use Facades\App\Queries\Site\Home\TextsQuery;
use Facades\App\Queries\Site\Home\PostsQuery;
use Facades\App\Queries\Site\Home\BriefsQuery;
use Facades\App\Queries\Site\Home\ForecastsQuery;
use Facades\App\Queries\Site\Home\UsersQuery;
use Facades\App\Queries\Site\Home\BookmakersQuery;
use Facades\App\Queries\Site\Home\DealsQuery;
use Facades\App\Queries\Site\Home\MatchesQuery;
use Facades\App\Queries\Site\Home\TournamentsQuery;
use Facades\App\Queries\Site\Home\BenefitsQuery;

class HomeController extends Controller
{
	public function index()
	{
		$sitesection = TextsQuery::get();                       // Тексты страницы
		$posts		 = PostsQuery::get();                       // Топ публикаций
		$briefs		 = BriefsQuery::get();                      // Топ новостей
		$forecasts	 = ForecastsQuery::get();                   // Топ прогнозов
		$users	 	 = UsersQuery::get();                       // Топ капперов
		$bookmakers	 = BookmakersQuery::get();                  // Топ букмекеров
		$deals	 	 = DealsQuery::get();                       // Топ акций
		$matches	 = MatchesQuery::get();                     // Топ матчей
		$sports	 	 = TournamentsQuery::get();                 // Топ турниров
		$benefits	 = BenefitsQuery::get();                    // Список преимуществ

        $sitesection = \App\Sitesection::query()
			->selectBySlug('home')
            ->first();
//        dd($sitesection);

        Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sports',
			'sitesection',
			'benefits',
			'bookmakers',
			'deals',
			'forecasts',
			'matches',
			'posts',
			'briefs',
			'users'
		));
	}
}
