<?php

$fields = require('field.php');

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'accepted'             => 'The :attribute must be accepted.',
	'active_url'           => 'The :attribute is not a valid URL.',
	'after'                => 'The :attribute must be a date after :date.',
	'alpha'                => 'The :attribute may only contain letters.',
	'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
	'alpha_num'            => 'The :attribute may only contain letters and numbers.',
	'array'                => 'The :attribute must be an array.',
	'before'               => 'The :attribute must be a date before :date.',
	'between'              => [
		'numeric' => 'The :attribute must be between :min and :max.',
		'file'    => 'The :attribute must be between :min and :max kilobytes.',
		'string'  => 'The :attribute must be between :min and :max characters.',
		'array'   => 'The :attribute must have between :min and :max items.',
	],
	'boolean'              => 'Поле :attribute должно быть Да или Нет.',
	'confirmed'            => 'Подтвердите поле :attribute.',
	'date'                 => 'Поле :attribute должно содержать корректную дату.',
	'date_format'          => 'Формат поля :attribute должно совпадать с форматом :format.',
	'different'            => 'The :attribute and :other must be different.',
	'digits'               => 'Поле :attribute должно быть :digits цифрами.',
	'digits_between'       => 'The :attribute must be between :min and :max digits.',
	'distinct'             => 'The :attribute field has a duplicate value.',
	'email'                => 'Поле :attribute должно содержать действительный адрес электронной почты.',
	'exists'               => 'Выбранное значение :attribute не существует.',
	'filled'               => 'Поле :attribute должно быть заполнено.',
	'image'                => 'Поле :attribute должно содержать изображение.',
	'in'                   => 'Неверное значение поля :attribute.',
	'in_array'             => 'The :attribute field does not exist in :other.',
	'integer'              => 'Поле :attribute должно быть числом.',
	'ip'                   => 'Поле :attribute должно быть IP адресом.',
	'json'                 => 'The :attribute must be a valid JSON string.',
	'max'                  => [
		'numeric' => 'Максимальное значение поля :attribute - :max.',
		'file'    => ':attribute должно быть максимум :max кб.',
		'string'  => 'Максимальное количество символов поля :attribute - :max.',
		'array'   => 'The :attribute may not have more than :max items.',
	],
	'mimes'                => 'The :attribute must be a file of type: :values.',
	'min'                  => [
		'numeric' => 'Минимальное значение поля :attribute - :min.',
		'file'    => ':attribute должно быть минимум :min кб.',
		'string'  => 'Минимальное количество символов поля :attribute - :min.',
		'array'   => 'The :attribute must have at least :min items.',
	],
	'not_in'               => 'The selected :attribute is invalid.',
	'numeric'              => 'Поле :attribute должно быть числом.',
	'present'              => 'The :attribute field must be present.',
	'regex'                => 'Поле :attribute имеет недопустимый формат.',
	'required'             => 'Не заполнено поле :attribute.',
	'required_if'          => 'The :attribute field is required when :other is :value.',
	'required_unless'      => 'The :attribute field is required unless :other is in :values.',
	'required_with'        => 'Поле :attribute, при наличии поля :values, обязательно к заполнению.',
	'required_with_all'    => 'The :attribute field is required when :values is present.',
	'required_without'     => 'Поле :attribute должно быть заполнено, если не заполнено поле :values',
	'required_without_all' => 'The :attribute field is required when none of :values are present.',
	'same'                 => 'The :attribute and :other must match.',
	'size'                 => [
		'numeric' => 'The :attribute must be :size.',
		'file'    => 'The :attribute must be :size kilobytes.',
		'string'  => 'The :attribute must be :size characters.',
		'array'   => 'The :attribute must contain :size items.',
	],
	'string'               => 'Поле :attribute должно быть строкой.',
	'timezone'             => 'Поле :attribute должно быть временной зоной.',
	'unique'               => ':attribute уже существует.',
	'url'                  => 'The :attribute format is invalid.',

	'mobile_number'        => 'Мобильный телефон должен состоять из 11 символов.',
	'unique_phone'         => ':attribute уже существует.',
	'old_password'         => 'Неверный пароль',
	'not_last_digits'      => 'Поле :attribute не должно оканчиваться на цифры',
	'unique_slug'          => ':attribute уже существует.',
	'match_time'           => 'Нельзя сделать прогноз на матч после :time',
	'forecast_balance'     => 'Недостаточно баллов на счете',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
		'login' => [
			'login' => 'Допускаются только латинские буквы и цифры',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => $fields['office'],
];
