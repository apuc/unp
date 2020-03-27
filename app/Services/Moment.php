<?php

namespace App\Services;

/**
 * Хелперы трансформации времени
 * Используется как фасад.
 */
class Moment
{
    /**
     * Форматирует дату и время с учетом национальных особенностей
     *
     */
    public function asDatetime(\Carbon\Carbon $datetime): string
    {
		return \IntlDateFormatter::create(
			config('app.locale'),
			\IntlDateFormatter::LONG,
			\IntlDateFormatter::SHORT,
			date_default_timezone_get()
		)->format(strtotime($datetime->toDateTimeString()));
    }

    /**
     * Форматирует дату с учетом национальных особенностей
     *
     */
    public function asDate(\Carbon\Carbon $datetime): string
    {
		return \IntlDateFormatter::create(
			config('app.locale'),
			\IntlDateFormatter::LONG,
			\IntlDateFormatter::NONE,
			date_default_timezone_get()
		)->format(strtotime($datetime->toDateTimeString()));
    }

    /**
     * Форматирует время с учетом национальных особенностей
     *
     */
    public function asTime(\Carbon\Carbon $datetime): string
    {
		return \IntlDateFormatter::create(
			config('app.locale'),
			\IntlDateFormatter::NONE,
			\IntlDateFormatter::SHORT,
			date_default_timezone_get()
		)->format(strtotime($datetime->toDateTimeString()));
    }

    /**
     * дата в формате ГГГГ-ММ-ДД
     *
     */
    public function asCompactDate(\Carbon\Carbon $datetime): string
    {
		return \IntlDateFormatter::create(
			config('app.locale'),
			\IntlDateFormatter::NONE,
			\IntlDateFormatter::NONE,
			date_default_timezone_get(),
			NULL,
			'Y-MM-dd'
		)->format(strtotime($datetime->toDateTimeString()));
    }

    /**
     * дата в формате ГГГГ-ММ-ДД ЧЧ:ММ
     *
     */
    public function asCompactDatetime(\Carbon\Carbon $datetime): string
    {
		return \IntlDateFormatter::create(
			config('app.locale'),
			\IntlDateFormatter::NONE,
			\IntlDateFormatter::NONE,
			date_default_timezone_get(),
			NULL,
			'Y-MM-dd HH:mm'
		)->format(strtotime($datetime->toDateTimeString()));
    }
}
