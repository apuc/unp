<?php

/**
 * Функции обработки данных
 *
 */

/**
 * Сидирование
 *
 */

if (! function_exists('seed')) {
	/**
     * Читает из json-файла массив записей для сидирования таблицы. Путь до каталога с данными сидирования задается через переменную окружения.
     *
     */
    function seed(string $tablename): array
    {
    	$data = File::get(sprintf("database/seeds/%s/%s.json", env('DB_SEED', 'data'), $tablename));

    	if (env('DB_SEED_FAST', false))
			return json_decode($data);
		else {
	        $parser = new Seld\JsonLint\JsonParser();
    		return $parser->parse($data);
		};
    }
}

if (! function_exists('insert')) {
	/**
     * Вставляет записи в таблицу $table из массива $records партиями по $portion элементов,
     * чтобы избежать переполнения количества placeholders для prepared statement.
     *
     */
    function insert(string $table, array $records, int $portion = 1000)
    {
        collect($records ?? [])
        	->chunk($portion)
        	->each(function ($subset) use ($table) {
	            DB::table($table)->insert($subset->toArray());
    	    });
    }
}

if (! function_exists('nullable')) {
	/**
	 * Если $value пустое, возвращает null
	 * Применяется при вставках значений в БД
     *
     */
    function nullable($value)
    {
    	return empty($value) ? null : $value;
    }
}

if (! function_exists('getCache')) {
	/**
	 * Получает ключ из кеша или выбрасывает 500-ю ошибку
     *
     */
    function cacheOrFail(string $variable)
    {
		if (\Illuminate\Support\Facades\Cache::has($variable))
        	return Cache::get($variable);

		abort(500, "Cache does not exist at {$variable}");	
    }
}

if (! function_exists('modelName')) {
	/**
     * Извлекает из строки вида \App\Modelname имя модели в нижнем регистре: modelname
     *
     */
    function modelName(string $modelClass): string
    {
		return mb_strtolower(str_after($modelClass, 'App\\'));
    }
}

if (! function_exists('modelEntity')) {
	/**
     * Преобразует имя класса модели к имени класса сущности
     *
     */
    function modelEntity(string $modelClass): string
    {
		return 'App\\Entities\\' . class_basename($modelClass) . 'Entity';
    }
}


