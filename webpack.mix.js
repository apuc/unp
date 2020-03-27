let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.version();

mix.sass('resources/sass/office/app.scss', 	'public/assets/office/css');
mix.sass('resources/sass/site/app.scss', 	'public/assets/site/css');

mix.copyDirectory('node_modules/ckeditor', 'public/assets/office/js/ckeditor');

mix.scripts([
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
		'resources/js/office/popper.min.js',
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'resources/js/office/enter.js',
		'resources/js/office/spin.js',
		'resources/js/office/crud.js',
		'resources/js/office/tab.js',
		'resources/js/office/search.js',
		'resources/js/office/siteset.filebrowse.js',
		'resources/js/office/siteset.checkboxgroup.js',
		'resources/js/office/siteset.gallery.js',
		'resources/js/office/filtertoggle.js',
//		'resources/js/office/notification.js',
		'resources/js/office/mask.js',
		'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js'
	],
	'public/assets/office/js/app.js'
);

mix.scripts([
		'node_modules/jquery/dist/jquery.js',
		'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js',
		'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
		'node_modules/vue/dist/vue.min.js',
		'resources/js/site/jquery.cookie.js',
		'resources/js/site/popper.min.js',
		'node_modules/bootstrap/dist/js/bootstrap.min.js',
		'resources/js/site/maxheight.js',
		'resources/js/site/owl.carousel.min.js',
		'resources/js/site/siteset.gallery.js',
		'resources/js/site/siteset.win.js',
		'resources/js/site/mobilemenu.js',
		'resources/js/site/siteset.sitemap.js',
		'resources/js/site/siteset.policy.js',
		'resources/js/site/siteset.scrollbar.js',
		'resources/js/site/siteset.scroll.js',
		'resources/js/site/siteset.filter.js',
		'resources/js/site/siteset.product.navigator.js',
		'resources/js/site/siteset.offers.js',
		'resources/js/site/siteset.matches.js',
		'resources/js/site/siteset.forecasts.js',
		'resources/js/site/siteset.profits.js',
		'resources/js/site/siteset.vue.filter.js',
		'resources/js/site/theme-script.js'
	],
	'public/assets/site/js/app.js'
);