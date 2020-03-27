<?php

namespace App\Providers;

use Validator;
use Facades\App\Services\User;
use Illuminate\Support\ServiceProvider;
use Morph;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */

	public function boot()
	{
		// валидация телефона
		Validator::extend('mobile_number', function($attribute, $value, $parameters) {
			// метод phone вернет false если в $value после чистки всех
			// символов кроме числовых и первой 7 или 8 останется более или менее 10
			// чисел
			return (boolean)Morph::phone($value);
		});

		// проверка уникальности телефона
		Validator::extend('unique_phone', function($attribute, $value, $parameters) {
			// проводим станадартную проверку на уникальность,
			// но только с переделанным телефоном
			$validator = Validator::make([$attribute => Morph::phone($value)], [
				$attribute => 'unique:' . implode(',', $parameters),
			]);

			return !$validator->fails();
		});

		// проверка окончания псевдонима на число
		Validator::extend('not_last_digits', function($attribute, $value) {
			return (bool)!preg_match('/\-[0-9]+$/', str_slug($value));
		});

		// проверка логина (допускаются только латинские буквы и цифры, без дефисов)
		Validator::extend('login', function($attribute, $value) {
			return (bool)preg_match('/^[a-zA-Z0-9]+$/', $value);
		});

		// проверка действующего пароля
		Validator::extend('old_password', function($attribute, $value) {
			return \Auth::validate([
				'email'		=> \Auth::user()->email,
				'password'	=> $value
			]);
		});

		// проверка времени матча
		Validator::extend('match_time', function($attribute, $value) {
			if (null === ($match = \App\Match::find($value)))
				return false;

			return ($match->started_at->timestamp > now()->addMinutes(config('forecast.time'))->timestamp);
		});

		// проверка баланса при совершение ставки
		Validator::extend('forecast_balance', function($attribute, $value) {
			return \Auth::user()->balance >= $value;
		});

		\Validator::replacer('match_time', function($message, $attribute, $rule, $parameters) {
			if (null !== ($match = \App\Match::find(request()->$attribute)))
				$message = str_replace(':time', $match->started_at->subMinutes(config('forecast.time'))->format('d.m.Y H:i'), $message);

			return $message;
		});

		// Обозреватели моделей
		\App\Banner::observe(\App\Observers\BannerObserver::class);
		\App\Benefit::observe(\App\Observers\BenefitObserver::class);

		\App\Bookmaker::observe(\App\Observers\BookmakerObserver::class);
		\App\Bookmakerpicture::observe(\App\Observers\BookmakerpictureObserver::class);
		\App\Bookmakertext::observe(\App\Observers\BookmakertextObserver::class);

		\App\Counter::observe(\App\Observers\CounterObserver::class);
		\App\Country::observe(\App\Observers\CountryObserver::class);

		\App\Deal::observe(\App\Observers\DealObserver::class);

		\App\Forecast::observe(\App\Observers\ForecastObserver::class);
		\App\Payment::observe(\App\Observers\PaymentObserver::class);
		\App\Forecastcomment::observe(\App\Observers\ForecastcommentObserver::class);
		\App\Forecastpicture::observe(\App\Observers\ForecastpictureObserver::class);

		\App\Helppicture::observe(\App\Observers\HelppictureObserver::class);
		\App\Helpsection::observe(\App\Observers\HelpsectionObserver::class);

		\App\Post::observe(\App\Observers\PostObserver::class);
		\App\Postcomment::observe(\App\Observers\PostcommentObserver::class);
		\App\Postpicture::observe(\App\Observers\PostpictureObserver::class);

		\App\Brief::observe(\App\Observers\BriefObserver::class);
		\App\Briefcomment::observe(\App\Observers\BriefcommentObserver::class);
		\App\Briefpicture::observe(\App\Observers\BriefpictureObserver::class);

		\App\Menuitem::observe(\App\Observers\MenuitemObserver::class);
		\App\Menusection::observe(\App\Observers\MenusectionObserver::class);

		\App\Sitepicture::observe(\App\Observers\SitepictureObserver::class);
		\App\Sitetext::observe(\App\Observers\SitetextObserver::class);

		\App\Sport::observe(\App\Observers\SportObserver::class);

		\App\Team::observe(\App\Observers\TeamObserver::class);
		\App\Tournament::observe(\App\Observers\TournamentObserver::class);

		\App\Sitesection::observe(\App\Observers\SitesectionObserver::class);
		\App\Social::observe(\App\Observers\SocialObserver::class);

		\App\User::observe(\App\Observers\UserObserver::class);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */

	public function register()
	{
		//
	}
}
