<header>
	<div class="header d-flex justify-content-between align-items-center">
		<div class="logo">
			<a href="<?php echo e(route('site.home.index')); ?>" title="Sportliga.com"><img src="<?php echo e(asset('preview/267/32/images/site/logo.jpg')); ?>" alt="Sportliga.com"></a>
		</div>

		<nav class="header-nav nav justify-content-center">
			<a class="nav-link" href="<?php echo e(route('site.brief.index')); ?>">Новости</a>
			<a class="nav-link" href="<?php echo e(route('site.post.index')); ?>">Статьи</a>
            <a class="nav-link" href="<?php echo e(route('site.forecast.index')); ?>">Прогнозы</a>
			<a class="nav-link" href="<?php echo e(route('site.bookmaker.index')); ?>">Букмекеры</a>
			<a class="nav-link" href="<?php echo e(route('site.deal.index')); ?>">Акции</a>
			<a class="nav-link" href="<?php echo e(route('site.user.index')); ?>">Капперы</a>
			<a class="nav-link" href="<?php echo e(route('site.match.index')); ?>">Матч-центр</a>
		</nav>

		<div class="user-box">
			<?php if(Auth::guest()): ?>
				
				<div class="logon-box">
    				<button type="button" class="user-link btn-theme" data-toggle="modal" data-target="#win-logon">Вход</button>
    				<a href="<?php echo e(url('/register')); ?>" class="user-link btn-theme">Регистрация</a>
				</div>
				
    			<div class="logon-box-m">
					<div class="logon-link" data-toggle="modal" data-target="#win-logon">
						<span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
					</div>
				</div>
			<?php else: ?>
				
				<div class="account-user-box">
					<div class="user-link">
						<div class="account-link" id="bankMenu" data-toggle="dropdown" data-display="static" aria-haspopup="false" aria-expanded="false">
							<span class="icon"><i class="fa fa-diamond" aria-hidden="true"></i></span><span class="a-content"><?php echo e(Auth::user()->balance); ?></span>
						</div>

						<?php if($lastforecasts->count()): ?>
							<div class="dropdown-menu win win-bank" aria-labelledby="bankMenu">
								<div class="win-cont">
									<?php $__currentLoopData = $lastforecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="post">
												<div class="post-date">
													<time><?php echo e($record['day']); ?><br><?php echo e($record['time']); ?></time>

													<?php switch($record['status_slug']):
														case ('win'): ?>
															<div class="val val-plus">+ <?php echo e($record['rate'] * $record['bet']); ?></div>
															<?php break; ?>;

														<?php case ('lose'): ?>
														<?php case ('confirmed'): ?>
															<div class="val val-minus">- <?php echo e($record['bet']); ?></div>
															<?php break; ?>;
													<?php endswitch; ?>
												</div>
												<div class="post-text">
													<div>
														<?php switch($record['status_slug']):
															case ('draw'): ?>
															<?php case ('win'): ?>
															<?php case ('confirmed'): ?>
															<?php case ('lose'): ?>
																<a href="<?php echo e(route('site.forecast.show', ['forecast' => $record['id']])); ?>"><strong><?php echo e($record['team1']); ?> - <?php echo e($record['team2']); ?></strong></a>
																<?php break; ?>;

															<?php default: ?>
																<strong><?php echo e($record['team1']); ?> - <?php echo e($record['team2']); ?></strong>
																<?php break; ?>;
														<?php endswitch; ?>
													</div>

													<div class="mb-2">
														<?php echo e($record['tournament']); ?>

														<?php if(false === mb_strpos(mb_strtolower($record['tournament']), mb_strtolower($record['stage']))): ?>
															<?php echo e($record['stage']); ?>

														<?php endif; ?>
													</div>

													<div class="mb-2">
														<div><?php echo e($record['outcometype']); ?></div>
														<div><?php echo e($record['outcomescope']); ?></div>
														<div><?php echo e($record['outcomesubtype']); ?></div>
													</div>

													<div class="mb-2">
														<div>К: <?php echo e($record['rate']); ?></div>
														<div>Ставка: <?php echo e($record['bet']); ?> баллов</div>
														<div>Статус: <span class="post-status-<?php echo e($record['status_slug']); ?>"><?php echo e($record['status_name']); ?><span></div>
													</div>
												</div>
											</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<div class="post-btns">
										<a class="btn btn-primary btn-sm" href="<?php echo e(route('account.forecast.index')); ?>">Все изменения банка</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>

					

					<div class="user-link account-user">
						<div class="account-link" id="accountMenu" data-toggle="dropdown" data-display="static" aria-haspopup="false" aria-expanded="false">
							<span class="icon-svg">
								<span class="icon-svg__account">
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 582.2 607">
										<path d="M292.7 452c-80.7 0-145.3-64.6-145.3-145.3S212 161.4 292.7 161.4 438 226 438 306.7 373.4 452 292.7 452zm0-258.3c-61.3 0-113 51.7-113 113s51.7 113 113 113 113-51.7 113-113-51.6-113-113-113z"></path>
										<path d="M334.7 32.3c9.7 0 22.6 6.5 22.6 16.1v45.2c32.3 9.7 67.8 29.1 96.9 58.1l38.7-22.6c3.2 0 3.2-3.2 6.5-3.2 6.5 0 9.7 3.2 12.9 6.5l38.7 67.8c3.2 6.5 0 16.1-6.5 22.6l-38.7 22.6c6.5 19.4 9.7 38.7 9.7 58.1s-3.2 38.7-9.7 58.1l38.7 22.6c6.5 3.2 9.7 12.9 6.5 22.6l-38.7 67.8c-3.2 6.5-9.7 6.5-12.9 6.5s-6.5 0-6.5-3.2l-35.5-22.6c-29.1 29.1-64.6 48.4-96.9 58.1v45.2c0 9.7-19.4 16.1-25.8 16.1h-77.5c-9.7 0-25.8-6.5-25.8-16.1v-45.2c-32.3-9.7-71-29.1-96.9-58.1l-38.7 22.6c-3.2 0-3.2 3.2-6.5 3.2-6.5 0-9.7-3.2-12.9-6.5l-38.7-67.8c-3.2-6.5-3.2-16.1 6.5-22.6l38.7-22.6c-6.5-19.4-9.7-38.7-9.7-58.1s3.2-38.7 9.7-58.1l-38.7-22.6c-6.5-3.2-9.7-12.9-6.5-22.6l38.7-67.8c3.2-6.5 9.7-6.5 12.9-6.5 3.2 0 6.5 0 6.5 3.2l35.5 22.6c29.1-29.1 64.6-48.4 96.9-58.1V48.4c0-9.7 16.1-16.1 25.8-16.1h71M331.5 0H254c-25.8 0-58.1 22.6-58.1 48.4V71c-32.3 9.7-48.4 25.8-71 42l-16.1-12.9c-6.5-3.2-12.9-6.5-22.6-6.5-16.1 0-32.3 9.7-42 22.6L5.3 184c-6.5 9.7-6.5 22.6-3.2 35.5s12.9 22.6 22.6 29.1l19.4 12.9c-3.2 12.9-3.2 29.1-3.2 42s0 29.1 3.2 42l-19.4 12.9c-9.7 6.5-19.4 16.1-22.6 29.1-3.2 12.9-3.2 25.8 3.2 35.5L44 490.8c9.7 16.1 25.8 22.6 42 22.6 9.7 0 16.1-3.2 22.6-6.5l16.1-12.9c22.6 19.4 38.7 32.3 71 42v22.6c0 25.8 29.1 48.4 58.1 48.4h77.5c25.8 0 58.1-22.6 58.1-48.4V536c0-9.7 45.2-25.8 67.8-42l16.1 12.9c6.5 3.2 12.9 6.5 22.6 6.5 16.1 0 32.3-9.7 42-22.6l38.7-67.8c6.5-9.7 6.5-22.6 3.2-35.5-3.2-12.9-12.9-22.6-22.6-29.1l-19.4-12.9c3.2-12.9 3.2-29.1 3.2-42 0-12.9 0-29.1-3.2-42l19.4-12.9c9.7-6.5 19.4-16.1 22.6-29.1 3.2-12.9 0-25.8-3.2-35.5l-38.7-67.8c-9.7-16.1-25.8-22.6-42-22.6-9.7 0-16.1 3.2-22.6 6.5L460.6 113c-22.6-19.4-67.8-32.3-67.8-42V48.4C392.8 22.6 367 0 337.9 0h-6.4z"></path>
									</svg>
								</span>
							</span>
							<span class="a-content"><?php echo e(Auth::user()->nick_name); ?></span>
						</div>

						<div class="dropdown-menu win win-account" aria-labelledby="accountMenu">
							<div class="win-cont">
								<h3>Личный кабинет</h3>
								<div class="win-account-name d-flex align-items-center">
									<div class="user-img">
										<img src="<?php echo e(asset('preview/48/48/storage/users/' . Auth::user()->avatar)); ?>" alt="<?php echo e(Auth::user()->nickname); ?>">
									</div>
									<div class="win-user-name">
										<h4><?php echo e(Auth::user()->nickname); ?></h4>
										<a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
										<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
											<?php echo e(csrf_field()); ?>

										</form>
									</div>
								</div>
								<div class="win-account-bank"><?php echo e(Auth::user()->balance); ?> <?php echo e(Lang::choice('балл|балла|баллов', Auth::user()->balance, [], 'ru')); ?></div>

								<ul class="navi">
									<li><a href="<?php echo e(route('account.dashboard.index')); ?>" class="nav-link">Моя статистика</a></li>
									
									
									
									<li class="dropdown-divider"></li>
									<li><a href="<?php echo e(route('account.forecast.index')); ?>" class="nav-link">Мои прогнозы</a> <a href="<?php echo e(route('account.forecast.create')); ?>" class="btn btn-primary btn-sm">сделать прогноз</a> <span class="bagde-gray"><?php echo e(Auth::user()->stat_forecasts); ?></span></li>
									<li><a href="<?php echo e(route('account.post.index')); ?>" class="nav-link">Мои статьи</a> <a class="btn btn-primary btn-sm" href="<?php echo e(route('account.post.create')); ?>">опубликовать статью</a> <span class="bagde-gray"><?php echo e(Auth::user()->stat_posts); ?></span></li>
									<li><a href="<?php echo e(route('account.brief.index')); ?>" class="nav-link">Мои новости</a> <a class="btn btn-primary btn-sm" href="<?php echo e(route('account.brief.create')); ?>">опубликовать</a> <span class="bagde-gray"><?php echo e(Auth::user()->stat_briefs); ?></span></li>
									<li class="dropdown-divider"></li>
									<li><a href="<?php echo e(route('account.personal.index')); ?>" class="nav-link">Изменение личных данных</a></li>
									<li><a href="<?php echo e(route('account.password.index')); ?>" class="nav-link">Изменение пароля</a></li>
									<li><a href="<?php echo e(route('account.social.index')); ?>" class="nav-link">Настройка авторизации</a></li>
									
									
									
									
									
									
									<li class="dropdown-divider"></li>
									<li>
										<a class="nav-link" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
    		<?php endif; ?>

			<div class="win-nav-link">
    			<span class="icon-svg" id="dropdownMenu" data-toggle="dropdown" data-display="static" aria-haspopup="false" aria-expanded="false">
    				<span class="icon-svg__menu">
        				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 296.6 254.3">
            				<path d="M275.4 254.3H21.2C8.5 254.3 0 245.8 0 233.1s8.5-21.2 21.2-21.2h254.3c12.7 0 21.2 8.5 21.2 21.2-.1 12.7-8.5 21.2-21.3 21.2zM275.4 148.3H21.2C8.5 148.3 0 139.8 0 127.1s8.5-21.2 21.2-21.2h254.3c12.7 0 21.2 8.5 21.2 21.2-.1 12.7-8.5 21.2-21.3 21.2zM275.4 42.4H21.2C8.5 42.4 0 33.9 0 21.2S8.5 0 21.2 0h254.3c12.7 0 21.2 8.5 21.2 21.2-.1 12.7-8.5 21.2-21.3 21.2z"/>
        				</svg>
                	</span>
            	</span>
            	<div class="dropdown-menu win-nav" aria-labelledby="dropdownMenu">
            		<div class="win-cont">
            			<div class="row">
            				<div class="col-md-4">
                    	    	<ul class="nav flex-column">
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.brief.index')); ?>">Новости</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.post.index')); ?>">Статьи</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.match.index')); ?>">Матч-центр</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.forecast.index')); ?>">Прогнозы</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.bookmaker.index')); ?>">Букмекеры</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.deal.index')); ?>">Акции</a></li>
                					<li class="nav-item"><a class="link" href="<?php echo e(route('site.user.index')); ?>">Капперы</a></li>
                				</ul>
							</div>
							<?php if($menusections->count()): ?>
            					<div class="col-md-4">
                    	        	<ul class="nav flex-column">
                    	        		<?php $__currentLoopData = $menusections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menusection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    	        			<?php if($menusection->menuitems->count()): ?>
                            					<li class="nav-item">
                            						<a class="link" href="<?php echo e($menusection->url); ?>"><?php echo e($menusection->name); ?></a>
                                   	            	<ul class="d-md-none">
                                   	            		<?php $__currentLoopData = $menusection->menuitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    						<li class="nav-item"><a href="<?php echo e($menuitem->url); ?>"><?php echo e($menuitem->name); ?></a></li>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               						</ul>
                            					</li>
                            				<?php else: ?>
		                            			<li class="nav-item"><a class="link" href="<?php echo e($menusection->url); ?>"><?php echo e($menusection->name); ?></a></li>
                            				<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    	        	</ul>
            					</div>
            				<?php endif; ?>
            				<div class="col-md-4">
                    	    	<ul class="nav flex-column">
                					<li class="nav-item"><a href="<?php echo e(route('site.about.index')); ?>">О проекте</a></li>
                					<li class="nav-item"><a href="<?php echo e(route('site.contact.index')); ?>">Контакты</a></li>
                					<li class="nav-item"><a href="<?php echo e(route('site.help.index')); ?>">Справка</a></li>
                					
                					<li class="nav-item"><a href="<?php echo e(route('site.legal.show', ['document' => 'rules'])); ?>">Правила сайта</a></li>
                    	    	</ul>
							</div>
						</div>
					</div>
            	</div>
			</div>
		</div>
	</div>

	<?php if($menusections->count()): ?>
		<div class="nav-box">
			<ul class="nav nav-fill menu">
				<?php $__currentLoopData = $menusections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menusection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php if($menusection->menuitems->count()): ?>
						<li class="nav-item menu-item">
							<a class="nav-link dropdown-toggle" href="<?php echo e($menusection->url ?? '#'); ?>"><?php echo e($menusection->name); ?></a>
        	            	<div class="win-nav win-menu">
            	        		<div class="win-cont">
                           	    	<ul>
                	       	    		<?php $__currentLoopData = $menusection->menuitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                	        			<li class="nav-item"><a href="<?php echo e($menuitem->url); ?>"><?php echo e($menuitem->name); ?></a></li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	               	   				</ul>
								</div>
        	            	</div>
						</li>
					<?php else: ?>
						<li class="nav-item"><a class="nav-link" href="<?php echo e($menusection->url); ?>"><?php echo e($menusection->name); ?></a></li>
					<?php endif; ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	<?php endif; ?>

</header>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/header.blade.php ENDPATH**/ ?>