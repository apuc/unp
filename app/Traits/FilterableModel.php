<?php

namespace App\Traits;

trait FilterableModel
{
	public function isFilterable($field)
	{
		return in_array($field, $this->filterable);
	}

	public function getFilterable()
	{
		return $this->filterable;
	}

	// Gate Filter

	public function scopeFilterBy($query, $field, $value)
	{
		$query->{'filterBy' . studly_case($this->isFilterable($field) ? $field : $this->filterable[0])}($value);
	}

	public function scopeFilter($query)
	{
		// получаем список полей из request (отрезая у поле filter_ и _id
		// если есть)
		$parameters	= getFilterValues();

		// листаем разрешенные поля
		foreach($this->filterable as $field) {

			// если данное поле НЕ нужно фильтровать
			if (!$parameters->has($field))
				continue;

			// если существует метод
			if (method_exists($this, 'scopeFilterBy' . studly_case($field)))
				// запускаем его
				$query->{'filterBy' . studly_case($field)}($parameters->get($field));

			// действие по умолчанию
			else
				$this->filter(
					$query,
					$field,
					$parameters->get($field)
				);
		}
	}

	private function filter($query, $field, $value)
	{
		// поднимаем сущность
		$entityName	= modelEntity(get_class($this));
		$entity		= $entityName::create($this, 'show');
		// получаем колонку (алиасполя_id или алиасполя. зависит
		// от контрола)
		$column		= $entity->property($field, 'control') == 'search' || $entity->property($field, 'control') == 'select' ? $field . '_id' : $field;
		// получаем имя таблицы. если таблица указана в модели, то берем имя оттуда.
		// если не указана, то собираем из имени модели (\App\ИмяМодели -> имя_модeлиs)
		$table		= $this->table ?? str_plural(snake_case(class_basename(get_class())));

		switch ($type = $entity->property($field, 'type')) {
			case 'datetime':
			case 'date':
				if (is_array($value)) {
					// сбиваем ключи
					$value = [$value[0] ?? null, $value[1] ?? null];

					$query->where(function ($query) use ($column, $value, $type, $table) {
						// если прислана только "от"
						if (
								!date_parse($value[0])['error_count']
							&&	date_parse($value[1])['error_count']
						)
							$query->where("{$table}.{$column}", '>=', \Carbon\Carbon::parse($value[0])->format('Y-m-d' . ($type == 'datetime' ? ' H:i:s' : '')));

						// если прислана только "до"
						elseif (
								!date_parse($value[1])['error_count']
							&&	date_parse($value[0])['error_count']
						)
							$query->where("{$table}.{$column}", '<=', \Carbon\Carbon::parse($value[1])->format('Y-m-d' . ($type == 'datetime' ? ' H:i:s' : '')));

						// если прислано две даты
						elseif (
								!date_parse($value[0])['error_count']
							&&	!date_parse($value[1])['error_count']
						)
							$query->whereBetween("{$table}.{$column}", [
								\Carbon\Carbon::parse($value[0])->format('Y-m-d' . ($type == 'datetime' ? ' H:i:00' : '')),
								\Carbon\Carbon::parse($value[1])->format('Y-m-d' . ($type == 'datetime' ? ' H:i:59' : '')),
							]);

						else
							return;
					});
				}

				else
					$query->whereDate("{$table}.{$column}", \Carbon\Carbon::parse($value)->format('Y-m-d'));

				break;

			case 'money':
			case 'numeric':
				if (is_array($value)) {
					// сбиваем ключи
					$value = [$value[0] ?? null, $value[1] ?? null];

					$query->where(function ($query) use ($column, $value, $table) {
						// если прислано только первое значение
						if (
								filled($value[0])
							&&	(!isset($value[1]) || empty($value[1]))
						) {
							// если первое значение не равно нулю
							if ($value[0] > 0 || $value[0] < 0)
								$query->where("{$table}.{$column}", '>=', $value[0]);

							// если ноль
							else
								$query->where(function ($query) use ($table, $column) {
									$query->where("{$table}.{$column}", '>=', 0);
									$query->orWhereNull("{$table}.{$column}");
								});
						}

						// если прислано только второе значение
						if (
								empty($value[0])
							&&	(isset($value[1]) && filled($value[1]))
						)
							$query->where(function ($query) use ($table, $column, $value) {
								$query->where("{$table}.{$column}", '<=', $value[1]);
								$query->orWhereNull("{$table}.{$column}");
							});

						// если прислано оба значения
						if (
								(isset($value[0]) && filled($value[0]))
							&&	(isset($value[1]) && filled($value[1]))
						) {
							// если первое значение не равно нулю
							if ($value[0] > 0 || $value[0] < 0)
								$query->where("{$table}.{$column}", '>=', $value[0]);

							// если ноль
							else
								$query->where(function ($query) use ($table, $column) {
									$query->where("{$table}.{$column}", '>=', 0);
									$query->orWhereNull("{$table}.{$column}");
								});

							$query->where("{$table}.{$column}", '<=', $value[1]);
						}
					});
				}
				else {
					if (is_numeric($value))
						$query->where("{$table}.{$column}", $value);
					else
						$query->where("{$table}.{$column}", 'like', "%{$value}%");
				}
				break;

			case 'id':
			case 'string':
				if (is_numeric($value))
					$query->where("{$table}.{$column}", $value);
				else
					$query->where("{$table}.{$column}", 'like', "%{$value}%");

				break;

			case 'boolean':
				if (filled($value) && (0 == $value || 1 == $value))
					$query->where("{$table}.{$column}", $value);
				break;
		}
	}
}
