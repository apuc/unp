<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class ParameterHandler
{
	/**
	 * реквест
	 *
	 * @var Request
	 */

	protected $request;

	/**
	 * массив с параметрами
	 *
	 * @var array
	 */

	protected $parameters;

	/**
	 * конструктор
	 *
	 * @param Request $request
	 */

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * получить свойство
	 *
	 * @return mixed
	 *
	 * @param string $parameter
	 * @param mixed $default
	 */

	public function get($parameter, $default = null)
	{
		return (true === $this->has($parameter)) ? $this->parameters[$parameter] : $default;
	}

	/**
	 * установить свойство
	 *
	 * @return ParameterHandler
	 *
	 * @param string $parameter
	 * @param mixed $value
	 */

	protected function set($parameter, $value)
	{
		$this->parameters[$parameter] = $value;

		return $this;
	}

	/**
	 * проверка существования параметра
	 *
	 * @return boolean
	 *
	 * @param string $parameter
	 */

	protected function has($parameter)
	{
		// проверяем есть ли параметр в списке известных
		// параметров
		if (!is_null($this->parameters) && array_key_exists($parameter, $this->parameters))
			return true;

		// проверяем в реквесте
		parse_str($parameter, $output);
		$key = array_keys($output)[0];
		if (!$this->request->has($key))
			return false;

		// если в имени есть квадратные скобки, это говорит о том что
		// мы запрашиваем какой-то внутрений элемент параметра
		if (false !== strpos($parameter, '['))
			// сохраняем параметр значение
			$this->set($parameter, call_user_func(function ($param, $value) {
				// избавляемся от пустых кважратных скобок в конце параметра
				$param	= preg_replace('/\[\]$/siu', '', $param);
				// подготоавливаем многоуровневый массв (маску)
				// для выборки по ней из массива значений
				parse_str($param, $output);
				$key	= array_keys($output)[0];
				$mask	= $output[$key];

				// получаем только тот уровень который запрашивали
				// если есть параметры p[1][max] и p[1][min], а мы запршиваем параметр
				// p[1][], то ответом будет массив содержащий 2 элемента max и min
				// так же можно запросить только max запросив p[1][max]
				return call_user_func(function ($dataset, $mask) {

					// если маска пустая
					if (empty($mask))
						return $dataset;

					$result = $dataset;
					while (true)
						foreach ($mask as $key => $value) {
							if (!isset($result[$key]))
								return false;

							if ($value == '')
								return $result[$key];

							$result	= $result[$key];
							$mask	= $value;
						}
				}, $value, $mask);
			}, $parameter, $this->request->$key));
		else
			// если скобок нет, то сохраняем как есть
			$this->set($parameter, $this->request->$key);

		return !(false === $this->get($parameter));
	}

	/**
	 * применения фильтра на модели
	 *
	 * @param Builder $query
	 */

	public function filter(Builder $query)
	{
		//
	}

	/**
	 * подгрузчик параметров
	 *
	 * @param boolean $filterout
	 */

	public function boot($filterout = false)
	{
		//
	}

	/**
	 * есть ли присланное значение среди параметра
	 *
	 * @return boolean
	 *
	 * @param string $parameter
	 * @param string $value
	 */

	protected function isCurrent($parameter, $value)
	{
		if (!$this->has($parameter))
			return false;

		if (!is_array($this->get($parameter)))
			return $this->get($parameter) == $value;

		else
			foreach ($this->get($parameter) as $v)
				if ($value == $v)
					return true;

		return false;
	}

	/**
	 * быстрый доступ к информации подгрузки
	 *
	 * @return mixed
	 *
	 * @param string $parameter
	 * @param mixed $default
	 */

	public function topical(...$arguments)
	{
		$topical = $this->get('topical');

		if (empty($arguments))
			return $topical->getParameters() ?? [];

		else
			return (isset($arguments[1]))
				? $topical->get($arguments[0], $arguments[1])
				: $topical->get($arguments[0])
			;
	}

	/**
	 * содержимое сво-ва parameters
	 *
	 * @return mixed
	 */

	public function getParameters()
	{
		return $this->parameters;
	}
}
