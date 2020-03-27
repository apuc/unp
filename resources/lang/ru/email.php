<?php

return [
	'site' => [
		'shopreview' => [
			'subject' => "Новый отзыв от пользователя :user_name",
		],

		'callback' => [
			'subject' => "Запрос на обратный звонок: :name, :phone",
		],

		'feedback' => [
			'subject' => "Запрос на обратную связь: :user_name, :user_email, :feedbacktopic_name",
		],

		'order' => [
			'admin'		=> [
				'subject' => "Заказ №  :order, :sum р., :delivery_name, :delivery_phone, :delivery_address",
			],
			'client'	=> [
				'subject' => "Ваш заказ № :order на :site_name",
			],
		],

		'registration' => [
			'subject' => "Регистрация пользователя :login",
		],

		'autoregistration' => [
			'subject' => "авторегистрация пользователя :user_name",
		],
	],
];
