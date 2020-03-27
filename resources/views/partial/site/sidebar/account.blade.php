<ul class="submenu">
	<li><a href="{{ route('account.dashboard.index') }}" data-value="personal-data">Моя статистика</a></li>
</ul>

<ul class="submenu">
	<li><a href="{{ route('account.forecast.index') }}" data-value="personal-data">Мои прогнозы</a></li>
	<li><a href="{{ route('account.post.index') }}" data-value="password-change">Мои статьи</a></li>
	<li><a href="{{ route('account.brief.index') }}" data-value="social-authorization">Мои новости</a></li>
	{{--<li><a href="{{ route('account.issue.index') }}" data-value="social-authorization">Мои обращения</a></li>--}}
</ul>

<ul class="submenu">
	<li><a href="{{ route('account.personal.index') }}">Изменение личных данных</a></li>
	<li><a href="{{ route('account.password.index') }}">Изменение пароля</a></li>
	<li><a href="{{ route('account.social.index') }}">Настройка авторизации</a></li>
	{{--<li><a href="{{ route('account.notice.index') }}">Настройка уведомлений</a></li>--}}
	{{--<li><a href="{{ route('account.event.index') }}">Последняя активность</a></li>--}}
</ul>

<ul class="submenu">
	<li>
		<a data-value="personal-data" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
	</li>
</ul>
