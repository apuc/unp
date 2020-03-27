<?php

namespace App\Services;

/**
 * Хелперы оформления
 * Используется как фасад.
 */
class Decor
{
	/**
	 * Generate diapason between $startYear and current year
	 *
	 * @param  int     $startYear
	 * @param  string  $dash
	 * @return string
	 */
	public function copyrightYear(int $startYear, string $dash = '–'): string
	{
		return $startYear . ($startYear == ($currentYear=date("Y")) ? '' : $dash . $currentYear);
	}
}
