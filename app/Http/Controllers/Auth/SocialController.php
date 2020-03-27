<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Two\InvalidStateException;

class SocialController extends Controller
{
	/**
	 *
	 *
	 */

	public function redirectToVkontakte()
	{
		return \Socialite::driver('vkontakte')->redirect();
	}

	/**
	 *
	 *
	 */

	public function handleVkontakteCallback()
	{
		try {
			$account = \Socialite::driver('vkontakte')->user();

			return $this->handle([
				'socialaccount_id'	=> $account->getId(),
				'name'				=> $account->getName(),
				'email'				=> $account->accessTokenResponseBody['email'] ?? null,
				'avatar'			=> $account->getAvatar(),
				'social'			=> 'vk',
			]);
		}
		catch (InvalidStateException $e) {
			return view('auth.error', [
				'social' => 'vk',
			]);
		}
	}

	/**
	 *
	 *
	 */

	public function redirectToFacebook()
	{
		return \Socialite::driver('facebook')->redirect();
	}

	/**
	 *
	 *
	 */

	public function handleFacebookCallback()
	{
		try {
			$account = \Socialite::driver('facebook')->user();

			return $this->handle([
				'socialaccount_id'	=> $account->getId(),
				'name'				=> $account->getName(),
				'email'				=> $account->getEmail(),
				'avatar'			=> $account->getAvatar(),
				'social'			=> 'facebook',
			]);
		}
		catch (InvalidStateException $e) {
			return view('auth.error', [
				'social' => 'facebook',
			]);
		}
	}

	/**
	 *
	 *
	 */

	public function redirectToGoogle()
	{
		return \Socialite::driver('google')->redirect();
	}

	/**
	 *
	 *
	 */

	public function handleGoogleCallback()
	{
		try {
			$account = \Socialite::driver('google')->user();

			return $this->handle([
				'socialaccount_id'	=> $account->getId(),
				'name'				=> $account->getName(),
				'email'				=> $account->getEmail(),
				'avatar'			=> $account->getAvatar(),
				'social'			=> 'google',
			]);
		}
		catch (InvalidStateException $e) {
			return view('auth.error', [
				'social' => 'google',
			]);
		}
	}

	/**
	 *
	 *
	 */

	private function handle(array $data)
	{
		// если пользователь не авторизован
		if (true === \Auth::guest()) {
			// поиск юзера через соц сеть
			$user = \App\User::query()
				->whereHas('usersocials', function ($query) use ($data) {
					$query
						->where('account', $data['socialaccount_id'])
						->whereHas('social', function ($query) use ($data) {
							$query->where('slug', $data['social']);
						})
					;
				})
				->first()
			;

			// если не получилось получить юзера черз соц сеть
			if (null === $user) {
				// пробуем получить юзера напрямую использую мыло
				if (null === ($user = \App\User::where('email', $data['email'])->first()))
					// если ничего не получилось передаем данные на регистрацию
					return redirect('register/social')->withInput($data);

				// цепляем новый акк соц сети к аккаунта лары
				else {
					$social = \App\Social::where('slug', $data['social'])->first();

					// можно ли крепить соц еть к акку
					$validator = Validator::make(['user_id' => $user->id, 'social_id' => $social->id], [
						'social_id' => 'unique_with:usersocials,user_id',
					]);

					// если да
					if (!$validator->fails()) {
						// крепим
						$usersocial = new \App\Usersocial;
						$usersocial->user_id	= $user->id;
						$usersocial->social_id	= $social->id;
						$usersocial->account	= $data['socialaccount_id'];
						$usersocial->save();
					}
				}
			}

			\Auth::login($user);
			return redirect(route('account.dashboard.index'));
		}

		// если юзер авторизован
		else {
			$social = \App\Social::where('slug', $data['social'])->first();

			// можно ли крепить соц еть к акку
			$validator = Validator::make(['user_id' => \Auth::user()->id, 'social_id' => $social->id], [
				'social_id' => 'unique_with:usersocials,user_id',
			]);

			// если нельзя
			if ($validator->fails())
				// возвращаем ошибку
				return redirect(route('account.social.index'))
					->withErrors($validator);
				;

			// если можно, то крепим
			$usersocial = new \App\Usersocial;
			$usersocial->user_id	= \Auth::user()->id;
			$usersocial->social_id	= $social->id;
			$usersocial->account	= $data['socialaccount_id'];
			$usersocial->save();

			return redirect(route('account.social.index'));
		}
	}
}
