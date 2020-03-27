<ul class="submenu">
	<li><a href="<?php echo e(route('account.dashboard.index')); ?>" data-value="personal-data">Моя статистика</a></li>
</ul>

<ul class="submenu">
	<li><a href="<?php echo e(route('account.forecast.index')); ?>" data-value="personal-data">Мои прогнозы</a></li>
	<li><a href="<?php echo e(route('account.post.index')); ?>" data-value="password-change">Мои статьи</a></li>
	<li><a href="<?php echo e(route('account.brief.index')); ?>" data-value="social-authorization">Мои новости</a></li>
	
</ul>

<ul class="submenu">
	<li><a href="<?php echo e(route('account.personal.index')); ?>">Изменение личных данных</a></li>
	<li><a href="<?php echo e(route('account.password.index')); ?>">Изменение пароля</a></li>
	<li><a href="<?php echo e(route('account.social.index')); ?>">Настройка авторизации</a></li>
	
	
</ul>

<ul class="submenu">
	<li>
		<a data-value="personal-data" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
	</li>
</ul>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/sidebar/account.blade.php ENDPATH**/ ?>