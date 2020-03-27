<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Events\Registered;

use App\Events\ForecastCreated;
use App\Events\ForecastUpdated;
use App\Events\ForecastDestroy;

use App\Events\BriefCreated;
use App\Events\BriefUpdated;
use App\Events\BriefDestroy;

use App\Events\PostCreated;
use App\Events\PostUpdated;
use App\Events\PostDestroy;

use App\Events\ForecastcommentCreated;
use App\Events\ForecastcommentUpdated;
use App\Events\ForecastcommentDestroy;

use App\Events\BriefcommentCreated;
use App\Events\BriefcommentUpdated;
use App\Events\BriefcommentDestroy;

use App\Events\PostcommentCreated;
use App\Events\PostcommentUpdated;
use App\Events\PostcommentDestroy;

use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */

	protected $listen = [
		// регистрация
		Registered::class => [
			'App\Listeners\HookSocial',
			'App\Listeners\SendPasswordForClient',
		],
		// прогнозы
		/*
		ForecastCreated::class => [
			'App\Listeners\ChangeUserBalance',
			'App\Listeners\UpdateForecastStat',
		],
		ForecastUpdated::class => [
			'App\Listeners\ChangeUserBalance',
			'App\Listeners\UpdateForecastStat',
		],
		ForecastDestroy::class => [
			'App\Listeners\ChangeUserBalance',
			'App\Listeners\UpdateForecastStat',
		],
		ForecastcommentCreated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		ForecastcommentUpdated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		ForecastcommentDestroy::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		*/

		// новости
		/*
		BriefCreated::class => [
			'App\Listeners\UpdateBriefsCount',
		],
		BriefUpdated::class => [
			'App\Listeners\UpdateBriefsCount',
		],
		BriefDestroy::class => [
			'App\Listeners\UpdateBriefsCount',
		],
		BriefcommentCreated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		BriefcommentUpdated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		BriefcommentDestroy::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		*/

		// статьи
		/*
		PostCreated::class => [
			'App\Listeners\UpdatePostsCount',
		],
		PostUpdated::class => [
			'App\Listeners\UpdatePostsCount',
		],
		PostDestroy::class => [
			'App\Listeners\UpdatePostsCount',
		],
		PostcommentCreated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		PostcommentUpdated::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		PostcommentDestroy::class => [
			'App\Listeners\UpdateCommentsCount',
		],
		*/

		// соцсети
		\SocialiteProviders\Manager\SocialiteWasCalled::class => [
			// add your listeners (aka providers) here
			'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
			'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
			'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
		],
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */

	public function boot()
	{
		parent::boot();

		//
	}
}
