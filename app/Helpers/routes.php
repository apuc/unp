<?php

/**
 * Функции сокращения записи часто используемых маршрутов системы
 *
 */

if (! function_exists('resource')) {
	/**
     * Создает массив имен роутинга для ресурсного контроллера.
     *
     */
    function resource(string $entity): array
    {
    	return [
    		'index'		=> "$entity.index",
    		'create'	=> "$entity.create",
    		'store'		=> "$entity.store",
			'show'		=> "$entity.show",
			'edit'		=> "$entity.edit",
			'update'	=> "$entity.update",
            'destroy'	=> "$entity.destroy",
    	];
    }
}
