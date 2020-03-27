<?php

/**
 * Общие сервисные маршруты
 *
 */

Route::get('/sitemap.xml',	'Site\SitemapController@xml')->name('sitemap.xml');
Route::get('/robots.txt',	'Site\RobotsController@index')->name('robots.txt');
Route::get('/preview/{w}/{h}/{image}', 'Site\PreviewController@index')->name('preview')->where([
	'w'     => '[0-9]+',
	'h'     => '[0-9]+',
	'image' => '[0-9\/a-z\_\-\.]+'
]);

Route::get('/debug/matches',			'Debug\MatchController@index')	->name('debug.match.index');
Route::get('/debug/matches/{match}',	'Debug\MatchController@show')	->name('debug.match.show');