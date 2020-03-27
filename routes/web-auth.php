<?php

/**
 * Авторизация и регистрация
 *
 */

// Стандартный набор маршрутов
Auth::routes();

Route::get('register/social',			'Auth\RegisterController@social')					->name('social');

Route::get('login/vkontakte',			'Auth\SocialController@redirectToVkontakte')		->name('login.vkontakte');
Route::get('login/vkontakte/callback',	'Auth\SocialController@handleVkontakteCallback')	->name('login.vkontaktecallback');

Route::get('login/facebook',			'Auth\SocialController@redirectToFacebook')			->name('login.facebook');
Route::get('login/facebook/callback',	'Auth\SocialController@handleFacebookCallback')		->name('login.facebookcallback');

Route::get('login/google',				'Auth\SocialController@redirectToGoogle')			->name('login.google');
Route::get('login/google/callback',		'Auth\SocialController@handleGoogleCallback')		->name('login.googlecallback');