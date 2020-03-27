<?php

return [
	'office' => [
		'bannerpost'		=> 'Раздел :sitesection / Баннер :banner',
		'bannersection'		=> ':id / Место ":bannerplace" / Раздел ":sitesection"',
//		'user'				=> ':name, :email, :phone',
		'user'				=> ':name',
		'issue'				=> ':id, от :posted_at',
		'forecast'			=> ':id, от :posted_at',
		'offer'				=> ':bookmaker :outcome',
		'outcome'			=> ':match :outcometype/:outcomescope/:outcomesubtype',
		'match'				=> ':name (:started_at)',
	],
	'site' => [
		'forecast'			=> ':team1 - :team2; :outcometype/:outcomescope/:outcomesubtype; :user',
	],
];