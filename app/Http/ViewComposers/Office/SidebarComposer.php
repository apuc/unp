<?php

namespace App\Http\ViewComposers\Office;

use Auth;
use Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class SidebarComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */

	public function compose(View $view)
	{
		$item		= $view->getData()['sidebar']; // Получаем данные об активном пункте из view, сформированные конструктором контроллера
		$sections	= call_user_func(
			function () {
				$sections = config('menu.office');

				// листаю все секции
				foreach ($sections as $section => $groups) {

					// проверяю на доступность пунктов внутри секции
					if (
						collect($groups)->filter(function ($items, $group) {
							return !collect($items)->filter(function ($permission, $item) {
								list($model, $action) = explode('@', $permission);
								return Auth::user()->can($action, 'App\\' . Str::title($model));
							})->isEmpty();
						})->isEmpty()
					) {
						// если ниодин пункт не доступен
						// шлепаем секцию
						unset($sections[$section]);
						continue;
					}

					// листаем группы секции
					foreach ($groups as $group => $items) {

						// фильтруем пункты
						$items = collect($items)->filter(function ($permission, $item) {
							list($model, $action) = explode('@', $permission);
							return Auth::user()->can($action, 'App\\' . $model);
						});

						// если нет пунктов
						if ($items->isEmpty())
							// шлепаем секцию
							unset($sections[$section][$group]);

						// если есть
						else
							// заполняем отфильтрованным
							$sections[$section][$group] = $items->toArray();
					}
				}

				return collect($sections);
			}
		);

		// первая секция
		$section  = $sections->keys()->first();

		// первая группа
		$group    = collect(
			$sections->get($section)
		)->keys()->first();

		// определяем выбранную секцию
		$activeSection = $sections->search(
			function ($groups, $section) use ($item) {
				return (collect($groups))->search(
					function ($items, $group) use ($item) {
						return isset($items[$item]);
					}
				);
			}
		);

		// определяем выбранную группу
		$activeGroup = call_user_func(
			function () use ($sections, $item) {
				foreach ($sections as $section)
					if (
						$group = (collect($section))->search(
							function ($items, $group) use ($item) {
								return isset($items[$item]);
							}
						)
					)
						return $group;

				return false;
			}
		);

		$view->with('sections',       $sections->all());
		$view->with('activeSection',  $activeSection === false ? $section : $activeSection);
		$view->with('activeGroup',    $activeGroup === false   ? $group   : $activeGroup);
		$view->with('activeItem',     $item);
	}
}


