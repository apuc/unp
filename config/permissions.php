<?php

/***************************************************************************
 *
 *  УРОВНИ ДОСТУПА К ПРОСТЫМ ОПЕРАЦИЯМ (sidebar, CREATE, REPORT, etc.)
 *
 *  0 - нет доступа
 *  1 - есть доступ
 *
 *  УРОВНИ ДОСТУПА К ОПЕРАЦИЯМ МОДИФИКАЦИИ ДАННЫХ (READ, UPDATE, DELETE)
 *
 *  0 - нет доступа
 *  1 - свои
 *  2 - групповые (организации, в которых принимает участие)
 *  3 - все записи
 *
**/

return [
	//                  	 ПОСЕТИТЕЛЬ			ОПЕРАТОР			АДМИНИСТРАТОР	ЖУРНАЛИСТ

	'Action' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Actiongroup' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Actiontype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Answer' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Banner' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannercampaign' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannerformat' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannerimpression' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannerpost' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannerplace' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bannersection' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Benefit' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bookmaker' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bookmakerpicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Bookmakertext' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Brief' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Briefcomment' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Briefpicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Briefstatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Brieftag' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Brieftournament' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Commentstatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Counter' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Country' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Customgroup' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Customparam' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Customtype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Deal' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Dealtype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Event' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Forecast' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Forecastcomment' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Forecastpicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Forecaststatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Gender' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Helppicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Helpsection' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Helpquestion' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Issue' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Issuestatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Issuetype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Legaldocument' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Legaledition' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Match' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Matchstatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Menuitem' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Menusection' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Notice' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Noticeban' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Noticestatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Noticetemplate' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Noticetype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Outcome' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Outcometype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Participant' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Post' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Postcomment' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Postpicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Poststatus' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Posttag' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Posttournament' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
	],

	'Offer' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Role' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Season' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Sitepicture' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Sitesection' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Sitetext' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Social' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Sport' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Stage' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Tag' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Team' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Tournament' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Tournamenttype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'User' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 1,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Usersocial' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Outcomescope' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Outcomesubtype' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],

	'Payment' => [
		'sidebar' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'create' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'read' 			=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'update' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
		'delete' 		=> ['customer' => 0,	'operator' => 0,	'admin' => 1,	'journalist' => 0,],
	],
];
