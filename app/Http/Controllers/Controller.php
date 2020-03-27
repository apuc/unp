<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Facades\App\Services\Crumb;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $route;
	protected $view;

	protected $routeUnit 		= '';
	protected $routeController	= '';
	protected $routeAction 		= '';

	public function __construct()
	{
		$this->setRoute();
		$this->setView();
		$this->setMenu();
	}

	private function setRoute()
	{
		$this->route = Route::currentRouteName();
		View::share('route', $this->route);
		View::share('routeName', $this->route);
	}

	private function setView()
	{
		$this->view  = 'page.' . $this->route;
		View::share('view',	$this->view);
		View::share('viewName',	$this->view);
	}

	private function setMenu()
	{
		if (3 == count($route = explode('.', Route::currentRouteName()))) {
			list($this->routeUnit, $this->routeController, $this->routeAction) = $route;

			View::share('routeUnit', 		$this->routeUnit);
			View::share('routeController',	$this->routeController);
			View::share('routeAction',		$this->routeAction);
		}
	}
}
