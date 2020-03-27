<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

/**
 * Пополняемое хранилище параметров для заполнения шаблонов локализации хлебных крошек.
 * Используется как фасад.
 */

class Crumb
{
	private $parameters = [];
	private $title;

	public function set($key, $value)
	{
		$this->parameters[$key] = $value;

		return $this;
	}

	public function get($key)
	{
		return $this->parameters[$key] ?? null;
	}

	public function params()
	{
		return $this->parameters;
	}

	public function caption()
	{
		return trans('page.' . Route::currentRouteName(), $this->parameters);
	}

	public function title()
	{
		if (Route::currentRouteName() == 'site.home.index')
			return trans('app.meta.title.main', [
				'seo_title'	=> trans('app.name'),
			]);

		else
			return trans('app.meta.title.other', [
				'title'		=> trans('page.' . Route::currentRouteName(), $this->params()),
				'seo_title'	=> $this->params()['seo_title'] ?? trans('app.name'),
			]);
	}

	public function name()
	{
		if (Route::currentRouteName() == 'site.home.index')
			return trans('app.name');
		else
			return trans('page.' . Route::currentRouteName(), $this->params());
	}

	public function keywords()
	{
		return $this->parameters['seo_keywords'] ?? null;
	}

	public function description()
	{
		return $this->parameters['seo_description'] ?? null;
	}
}
