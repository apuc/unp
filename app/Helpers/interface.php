<?php

/**
 * Функции, связанные с интерфейсом пользователя
 *
 */

if (! function_exists('id')) {
	/**
	 * Добивает нулями ID для формирования кода
	 *
	 */
	function code(string $id): string
	{
		return sprintf("%'.06d", $id);
	}
}

if (! function_exists('activeItem')) {
	/**
	 * Подсвечивает классом активный элемент меню, если текущий пункт $current равен активному $active
	 *
	 */
	function activeItem(string $route, array $parameters = []): string
	{
		return ( ('/' . rtrim(request()->path(), '/')) === (route($route, $parameters, false)) ) ? ' active' : '';
	}
}

if (! function_exists('activeSection')) {
	/**
	 * Подсвечивает классом активный элемент меню, если текущий пункт $current равен активному $active
	 *
	 */
	function activeSection(string $active): string
	{
		$elements = explode('.', Route::currentRouteName());

		if (count($elements) == 3) {
			list($area, $controller, $action) = $elements;
			return ($area . '.' . $controller) == $active ? ' active' : '';
		} else
			return $active == Route::currentRouteName() ? ' active' : '';
	}
}

if (! function_exists('activeSelected')) {
	/**
	 * Добавляет атрибут selected к тегу option в случае если первый параметр true
	 *
	 */
	function activeSelected($active): string
	{
		return $active ? ' selected="selected"' : '';
	}
}

if (! function_exists('activeChecked')) {
	/**
	 * Добавляет атрибут checked к тегу input в случае если первый параметр true
	 *
	 */
	function activeChecked($active): string
	{
		return $active ? ' checked="checked"' : '';
	}
}

if (! function_exists('menuItem')) {
	/**
	 * Добавляет атрибут checked к тегу input в случае если первый параметр true
	 *
	 */
	function active($current, $active): string
	{
		return $current == $active ? ' class="actice"' : '';
	}
}



