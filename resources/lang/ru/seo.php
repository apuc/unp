<?php

return [
	'site' => [
		'brief'		=> 'Новости - :sport - :description',
		'post'		=> 'Статьи - :sport - :description',
		'forecast'	=> 'Прогноз на матч :team1 - :team2, :tournament, :season - Исход: :outcometype, Время: :outcomescope, Прогноз: :outcomesubtype, Ставка: :bet, Букмекер: :bookmaker, Коэффициент: :rate',
		'bookmaker'	=> [
			'name'		=> 'Букмекер :name',
			'bonus'		=> ':bonus бонусов при регистрации',
			'phone'		=> 'Телефон: :phone',
			'email'		=> 'E-mail: :email',
			'address'	=> 'Адрес: :address',
		],
		'deal'	=> [
			'name'		=> ':name от :bookmaker. :dealtype.',
			'period'	=> [
				'name'			=> 'Акция действует',
				'started_at'	=> 'с :started_at',
				'finished_at'	=> 'по :finished_at',
			],
		],
		'user'	=> ':login, на сайте с :created_at Прогнозов: :stat_forecasts, Комментариев: :stat_comments, Баллов: :balance, Новостей: :stat_briefs, Статей: :stat_posts',
		'match'	=> 'Матч :team1 - :team2, :tournament, :season, Начало :day в :time',
	],
];