<?php

/**
 * Функции поддержки хлебных крошек
 *
 */

if (! function_exists('registerBreadcrumbsItem')) {
    /**
     * Регистрирует пункт хлебных крошек
     *
     */
    function registerBreadcrumbsItem($routeName, $parentName = null)
    {
    	Breadcrumbs::register($routeName, function($breadcrumbs, $parameters) use ($routeName, $parentName) {
        	if (isset($parentName))
        		$breadcrumbs->parent($parentName, $parameters);

    	    $breadcrumbs->push(	    	
    	    	// формируем текст ссылки, применяя к ней параметры массива описаний параметров
        		trans('page.' . $routeName, $parameters), 
        		// получаем массив параметров текущего роута и применяем его в качестве маски на общий массив всех параметров
        		route($routeName, collect(Route::current()->parameters())->only(Route::getRoutes()->getByName($routeName)->parameterNames())->all())
    	    );
    	});
    }
}

if (! function_exists('registerBreadcrumbsTree')) {
    /**
     * Регистрирует дерево хлебных крошек
     *
     */
    function registerBreadcrumbsTree($pageTree, $parent = null)
    {
    	foreach($pageTree as $key => $value) {
    		if (is_array($value)) {
    			registerBreadcrumbsItem($key, $parent);
    			registerBreadcrumbsTree($value, $key);
    		} else
    			registerBreadcrumbsItem($value, $parent);
    	}
    }
}

if (! function_exists('breadcrumbResources')) {
	/**
     * Создает фрагмент дерева хлебных крошек для ресурсной сущности.
     *
     */
    function breadcrumbResources(array $entities): array
    {
    	foreach($entities as $entity)
    		$tree["office.$entity.index"] = [
				"office.$entity.create",
				"office.$entity.show" => [
					"office.$entity.edit",
				],
			];

		return $tree;
    }
}
