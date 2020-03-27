<?php

namespace App\Queries;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

/** 
 * Базовый класс для инкапсуляции запросов (могут кешироваться)
 *
 */
abstract class Query
{
	private $params;	// Параметры запроса (массив ключ-значение)
	private $ttl;		// Время жизни запроса в 

	/** 
	 * Абстрактная функция - перекрывать телом запроса
	 *
	 */
	abstract public function run();

	/** 
	 * Конструктор (для красоты)
	 *
	 */
	public function create()
	{
		return $this;
	}

	/** 
	 * Установка времени задержки (в секундах)
	 *
	 */
	public function expire($seconds)
	{
	 	$this->ttl = $seconds;

	 	return $this;
	}

	/** 
	 * Установка значения параметра
	 *
	 */
	public function where($parameter, $value)
	{
		$this->params[strtolower($parameter)] = $value;
		ksort($this->params, SORT_STRING);

		return $this;
	}

	/** 
	 * Получение значения параметра
	 *
	 */
	public function value($parameter)
	{
		return $this->params[$parameter];
	}

	/** 
	 * Вычисление имени ключа для кеширования в зависимости от переданных параметров
	 *
	 */
	private function getKey()
	{
		$params = isset($this->params) ? '=' . md5(json_encode($this->params)) : '';

		return Str::before(Str::after(str_replace('\\', '.', strtolower(get_class($this))),	'app.queries.'), 'query') . $params;
	}

	/** 
	 * Передача значения параметра
	 *
	 */
	private function getTTL()
	{
		return $this->ttl ?? 15*60;
	}

	/** 
	 * Выполнить запрос и безусловно обновить кеш 
	 *
	 */
	public function put()
	{
		$value = $this->run();

		Cache::put($this->getKey(), $value, $this->getTTL());

		return $value;
	}

	/** 
	 * Получить результат запроса из кеша, если его там нет - выполнить и записать в кеш
	 *
	 */
	public function get()
	{
		if (Cache::has($this->getKey()))
			return Cache::get($this->getKey());
		else
			return $this->put();
	}

	/** 
	 * Очистить кеш запроса
	 *
	 */
	public function clean()
	{
		Cache::forget($this->getKey());
	}
}
