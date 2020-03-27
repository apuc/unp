<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composer([
				'partial.office.shell.sidebar-menu',
				'partial.office.shell.content-title',
			],
			'App\Http\ViewComposers\Office\SidebarComposer'
		);

		view()->composer([
				'partial.office.page.*',
				'partial.office.panel.header',
				'layout.office.*',
				'layout.site.*',
			],
			'App\Http\ViewComposers\Office\TitleComposer'
		);

		view()->composer([
				'layout.site.*',
			],
			'App\Http\ViewComposers\Site\TitleComposer'
		);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
