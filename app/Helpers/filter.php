<?php

/**
 * Функции обработки фильтра
 *
 */

if (!function_exists('isFilter')) {
	/**
	 * есть ли данные для фильтра
	 *
	 */

	function isFilter(): bool
	{
		return getFilterValues()->count() ? true : false;
	}
}

if (!function_exists('getFilterValues')) {
	/**
	 * есть ли данные для фильтра
	 *
	 */

	function getFilterValues(): \Illuminate\Support\Collection
	{
		$result		= collect();

		// получаем список полей из request (отрезая у поле filter_ и _id
		// если есть)
		$parameters	= collect(request()->all())->keyBy(function ($item, $key) {
			$key = str_after($key, 'f_');
			return (str_is('*_id', $key)) ? str_before($key, '_id') : $key;
		});

		foreach ($parameters as $key => $parameter)
			if (!emptyFilterValue($parameter))
				$result->put($key, $parameter);

		return $result;
	}
}

if (!function_exists('emptyFilterValue')) {
	/**
	 * пустое ли значение фильтра
	 *
	 * @param string $value значение
	 */

	function emptyFilterValue($value): bool
	{
		if (is_array($value)) {
			foreach ($value as $sub)
				if (false === emptyFilterValue($sub))
					return false;

			return true;
		}

		elseif (null === $value)
			return true;

		return false;
	}
}
