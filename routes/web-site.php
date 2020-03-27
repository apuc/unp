<?php

/**
 * Сайт
 *
 */

Route::get('/',											'HomeController@index')                 ->name('home.index');

Route::get('/briefs', 									'BriefController@index')				->name('brief.index');
Route::get('/briefs/filter', 							'BriefController@filter')				->name('brief.filter');
Route::get('/briefs/{brief}', 							'BriefController@show')					->name('brief.show');
Route::post('/briefs/{brief}/comment', 					'BriefController@comment')				->name('brief.comment');

Route::get('/posts', 									'PostController@index')					->name('post.index');
Route::get('/posts/filter', 							'PostController@filter')				->name('post.filter');
Route::get('/posts/{post}', 							'PostController@show')					->name('post.show');
Route::post('/posts/{post}/comment', 					'PostController@comment')				->name('post.comment');

Route::get('/forecasts', 								'ForecastController@index')				->name('forecast.index');
Route::get('/forecasts/filter', 						'ForecastController@filter')			->name('forecast.filter');
Route::get('/forecasts/{forecast}', 					'ForecastController@show')				->name('forecast.show');
Route::post('/forecasts/{forecast}/comment', 			'ForecastController@comment')			->name('forecast.comment');

Route::get('/bookmakers', 								'BookmakerController@index')			->name('bookmaker.index');
Route::get('/bookmakers/{bookmaker}', 					'BookmakerController@show')				->name('bookmaker.show');
Route::get('/bookmakers/{bookmaker}/{text}',			'BookmakerController@text')				->name('bookmaker.text');

Route::get('/deals', 									'DealController@index')					->name('deal.index');
Route::get('/deals/filter', 							'DealController@filter')				->name('deal.filter');
Route::get('/deals/{deal}', 							'DealController@show')					->name('deal.show');

Route::get('/users', 									'UserController@index')					->name('user.index');
Route::get('/users/{login}', 							'UserController@show')					->name('user.show');

Route::get('/matches', 									'MatchController@index')				->name('match.index');
Route::get('/matches/ajax', 							'MatchController@ajax')					->name('match.ajax');
Route::get('/matches/load', 							'MatchController@load')					->name('match.load');
Route::get('/matches/{match}', 							'MatchController@show')					->name('match.show');
Route::get('/matches/{match}/offers', 					'MatchController@offer')				->name('match.offer');

Route::get('/help', 									'HelpController@index')					->name('help.index');
Route::get('/help/ask', 								'HelpController@ask')					->name('help.ask');
Route::get('/help/{section}', 							'HelpController@section')				->name('help.section');

Route::get('/legal',									'LegalController@index')				->name('legal.index');
Route::get('/legal/{document}',							'LegalController@show')					->name('legal.show');

Route::get('/about', 									'AboutController@index')				->name('about.index');

Route::get('/contacts', 								'ContactController@index')				->name('contact.index');

Route::get('/sitemap', 									'SitemapController@index')				->name('sitemap.index');