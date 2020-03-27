<?php

/***************************************************************************
 *
 *  РЕГУЛИРОВКА ПОКАЗА РАЗЛИЧНЫХ КОМПОНЕНТОВ СИСТЕМЫ В ОТЛАДОЧНЫХ ЦЕЛЯХ
 *
**/

return [
	'banner' => [
		'branding' 		=> env('SHOW_BANNER_BRANDING',		true),
		'top' 			=> env('SHOW_BANNER_TOP',			true),
		'sidebar' 		=> env('SHOW_BANNER_SIDEBAR',		true),
		'bottom' 		=> env('SHOW_BANNER_BOTTOM',		true),
	],

	'section' => [
		'forecasts'		=> env('SHOW_SECTION_FORECASTS',	true),
		'deals'			=> env('SHOW_SECTION_DEALS',		true),
		'users'			=> env('SHOW_SECTION_USERS',		true),
		'matches'		=> env('SHOW_SECTION_MATCHES',		true),
	],

	'texts' => env('SHOW_TEXTS', true),
];
