<?php

/**
 * Личный кабинет
 *
 */

Route::get('/',											'DashboardController@index')			->name('dashboard.index');
Route::get('/profit',									'DashboardController@profit')			->name('dashboard.profit');
Route::get('/issues',									'IssueController@index')				->name('issue.index');

Route::get('/forecasts',								'ForecastController@index')				->name('forecast.index');
Route::get('/forecasts/create',							'ForecastController@create')			->name('forecast.create');
Route::post('/forecasts/create',						'ForecastController@store')				->name('forecast.store');

Route::get('/forecasts/filter',							'ForecastController@filter')			->name('forecast.filter');

Route::get('/forecasts/sports',							'ForecastController@sports')			->name('forecast.sports');
Route::get('/forecasts/tournaments',					'ForecastController@tournaments')		->name('forecast.tournaments');
Route::get('/forecasts/matches',						'ForecastController@matches')			->name('forecast.matches');
Route::get('/forecasts/offers',							'ForecastController@offers')			->name('forecast.offers');

Route::get('/forecasts/{match}/offers',					'ForecastController@offer')				->name('forecast.offer');
Route::get('/forecasts/{forecast_id}',					'ForecastController@show')				->name('forecast.show');

Route::get('/posts',									'PostController@index')					->name('post.index');
Route::get('/posts/create',								'PostController@create')				->name('post.create');
Route::post('/posts/create',							'PostController@store')					->name('post.store');
Route::get('/posts/{post_id}',							'PostController@show')					->name('post.show');
Route::get('/posts/{post_id}/edit',						'PostController@edit')					->name('post.edit');
Route::post('/posts/{post_id}/update',					'PostController@update')				->name('post.update');
Route::post('/posts/{post_id}/destroy',					'PostController@destroy')				->name('post.destroy');

Route::get('/briefs',									'BriefController@index')				->name('brief.index');
Route::get('/briefs/create',							'BriefController@create')				->name('brief.create');
Route::post('/briefs/create',							'BriefController@store')				->name('brief.store');
Route::get('/briefs/{brief_id}',						'BriefController@show')					->name('brief.show');
Route::get('/briefs/{brief_id}/edit',					'BriefController@edit')					->name('brief.edit');
Route::post('/briefs/{brief_id}/update',				'BriefController@update')				->name('brief.update');
Route::post('/briefs/{brief_id}/destroy',				'BriefController@destroy')				->name('brief.destroy');

Route::get('/profile',									'ProfileController@index')				->name('profile.index');
Route::match(['get', 'post'], '/personal',				'PersonalController@index')				->name('personal.index');
Route::match(['get', 'post'], '/password',				'PasswordController@index')				->name('password.index');
Route::get('/socials',									'SocialController@index')				->name('social.index');
Route::delete('/socials/{social_id}',					'SocialController@destroy')				->name('social.destroy');
Route::get('/notices',									'NoticeController@index')				->name('notice.index');
Route::get('/events',									'EventController@index')				->name('event.index');
