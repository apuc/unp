<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Хелперы трансформации различных величин (имени, телефона, денег)
 * Используется как фасад.
 *
 */
class Morph
{
	/**
	 * @return string|null
	 *
	 * @param Model $model
	 * @param array $field
	 */

	public function fullname(Model $model, $field = ['surname', 'name', 'patronym'])
	{
		list($surname, $name, $patronym) = $field;

		// полное ФИО
		if (
			   filled($model->$surname)
			&& filled($model->$name)
			&& filled($model->$patronym)
		)
			return trans(
				'user.fullname',
				[
					'surname'	=> $model->$surname,
					'name'		=> $model->$name,
					'patronym'	=> $model->$patronym,
				]
			);

		// только фамилия отчество
		if (
			   filled($model->$surname)
			&& filled($model->$name)
			&& empty($model->$patronym)
		)
			return trans(
				'user.shortname',
				[
					'surname' => $model->$surname,
					'name'	  => $model->$name,
				]
			);

		// только фамилия
		if (
			   filled($model->$surname)
			&& empty($model->$name)
			&& empty($model->$patronym)
		)
			return trans(
				'user.surname',
				[
					'surname' => $model->$surname,
				]
			);

		// только имя
		if (
			   empty($model->$surname)
			&& filled($model->$name)
			&& empty($model->$patronym)
		)
			return trans(
				'user.name',
				[
					'name' => $model->$name,
				]
			);

		return null;
	}

	/**
	 * Форматирует телефон number по маске pattern. Берем за основу то, что телефон обязательно начинаетсы на "+7" или "8"
	 *
	 * Маска +7 (%d%d%d) %d%d%d-%d%d-%d%d приведет телефон к виду +7 (123) 456-78-90
	 * Маска +7%d%d%d%d%d%d%d%d%d%d приведет телефон к виду +71234567890
	 *
	 * @return string
	 *
	 * @param string $number
	 * @param string $pattern
	 */

	public function phone($number, $pattern = '+7%d%d%d%d%d%d%d%d%d%d')
	{
		// обрабатываем телефон
		$phone = preg_replace('/[^0-9]/is', '', $number);
		$phone = preg_replace('/^(8|7)/is', '', $phone);

		// бьем строку телефона на массив
		$phone = preg_split('//u', $phone, -1, PREG_SPLIT_NO_EMPTY);

		if (10 !== count($phone))
			return false;

		return call_user_func_array('sprintf', array_merge(
			[$pattern],
			$phone)
		);
	}

	/**
	 * Форматирование денежных единиц
	 *
	 * @param string|float|integer $str
	 * @param string $dec
	 * @param string $sep
	 *
	 * @return string
	 */

	public function money($str, $dec = '.', $sep = ' '): string
	{
		$str = str_replace(' ', '', $str);

		switch (preg_match('/\./u', (float)$str)) {
			case 0:
				return number_format($str, 0, $dec, $sep);
				break;

			default:
				return number_format($str, 2, $dec, $sep);
				break;
		}
	}
}
