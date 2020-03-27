<?php

/**
 * Функции проверки прав доступа
 *
 */

if (! function_exists('can')) {
	/**
     * Проверяет права текущего пользователя на выполнение действия в формате "Сущность@действие"
     *
     */
    function can(string $action): bool
    {
    	list($entity, $ability) = explode('@', $action);

		return (bool)Auth::user()->can($ability, 'App\\' . $entity);
    }
}

if (! function_exists('canOrFail')) {
	/**
     * Проверяет права текущего пользователя на выполнение действия в формате "Сущность@действие"
     * Если нет доступа - выбрасывает исключение ошибки авторизации.
     *
     */
    function canOrFail(string $action)
    {
		abort_unless(
			can($action), 
			403, 
			trans('auth.action' . (config('app.debug') ? '.debug' : ''), ['action' => $action])
		);
    }
}

if (! function_exists('hasRole')) {
	/**
     * Проверяет, имеет ли данный пользователь роль
     *
     */
    function hasRole(string $role): bool
    {
    	return (Auth::user()->role->slug == $role);
    }
}

if (! function_exists('hasRoleOrFail')) {
	/**
     * Проверяет, имеет ли данный пользователь данную роль.
     * Если не имеет - выбрасывает исключение ошибки авторизации.
     *
     */
    function hasRoleOrFail(string $role)
    {
		abort_unless(
			hasRole($role), 
			403, 
			trans('auth.role' . (config('app.debug') ? '.debug' : '.production'), ['action' => $action])
		);
    }
}

if (! function_exists('isPasswordHash')) {
	/**
     * Проверяет, является ли строка хешем пароля.
     *
     */
	function isPasswordHash(string $str): bool
	{
		return ((60 === mb_strlen($str)) AND starts_with($str, '$2y$'));
	}
}

if (! function_exists('permission')) {
	/**
     * Проверяет право пользователя на действие модели в конфиге config.permissions
     *
     */
	function permission(\App\User $user, string $model, string $ability): bool
	{
	    $model 		= class_basename($model);
	    $ability    = snake_case($ability, '.');

		return (bool)config("permissions.{$model}.{$ability}.{$user->role->slug}");
	}
}

