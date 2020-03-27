<ul class="submenu">
	{{--
	@include('control.site.menu.item', [
		'route'		=> 'site.contact.index',
		'label'		=> 'Контакты',
		'current'	=> $current,
	])
	--}}

	{{--
	@include('control.site.menu.item', [
		'route'		=> 'site.about.index',
		'label'		=> 'О проекте',
		'current'	=> $current,
	])
	--}}

	@include('control.site.menu.item', [
		'route'		=> 'site.legal.index',
		'label'		=> 'Правовая информация',
		'current'	=> $current,
	])

	@include('control.site.menu.item', [
		'route'		=> 'site.help.index',
		'label'		=> 'Справка',
		'current'	=> $current,
	])

	{{--
	@include('control.site.menu.item', [
		'route'		=> 'site.help.ask',
		'label'		=> 'Задать вопрос',
		'current'	=> $current,
	])
	--}}
</ul>
