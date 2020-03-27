<header>
	<div class="header d-flex justify-content-between align-items-center">
		<div class="logo">
			<a href="{{ route('site.home.index') }}" title="Sportliga.com"><img src="{{ asset('preview/267/32/images/site/logo.jpg') }}" alt="Sportliga.com"></a>
		</div>

		<nav class="header-nav nav justify-content-center">
			<a class="nav-link" href="{{ route('site.brief.index') }}">Новости</a>
			<a class="nav-link" href="{{ route('site.post.index') }}">Статьи</a>
            <a class="nav-link" href="{{ route('site.forecast.index') }}">Прогнозы</a>
			<a class="nav-link" href="{{ route('site.bookmaker.index') }}">Букмекеры</a>
			<a class="nav-link" href="{{ route('site.deal.index') }}">Акции</a>
			<a class="nav-link" href="{{ route('site.user.index') }}">Капперы</a>
			<a class="nav-link" href="{{ route('site.match.index') }}">Матч-центр</a>
		</nav>

		<div class="user-box">
			@if (Auth::guest())
				{{-- для всех страниц --}}
				<div class="logon-box">
    				<button type="button" class="user-link btn-theme" data-toggle="modal" data-target="#win-logon">Вход</button>
    				<a href="{{ url('/register') }}" class="user-link btn-theme">Регистрация</a>
				</div>
				{{-- для мобилы --}}
    			<div class="logon-box-m">
					<div class="logon-link" data-toggle="modal" data-target="#win-logon">
						<span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
					</div>
				</div>
			@else
				{{-- для Личного кабинета --}}
				<div class="account-user-box">
					<div class="user-link">
						<div class="account-link" id="bankMenu" data-toggle="dropdown" data-display="static" aria-haspopup="false" aria-expanded="false">
							<span class="icon"><i class="fa fa-diamond" aria-hidden="true"></i></span><span class="a-content">{{ Auth::user()->balance }}</span>
						</div>

						@if ($lastforecasts->count())
							<div class="dropdown-menu win win-bank" aria-labelledby="bankMenu">
								<div class="win-cont">
									@foreach ($lastforecasts as $records)
										@foreach ($records as $record)
											<div class="post">
												<div class="post-date">
													<time>{{ $record['day'] }}<br>{{ $record['time'] }}</time>

													@switch($record['status_slug'])
														@case('win')
															<div class="val val-plus">+ {{ $record['rate'] * $record['bet'] }}</div>
															@break;

														@case('lose')
														@case('confirmed')
															<div class="val val-minus">- {{ $record['bet'] }}</div>
															@break;
													@endswitch
												</div>
												<div class="post-text">
													<div>
														@switch($record['status_slug'])
															@case('draw')
															@case('win')
															@case('confirmed')
															@case('lose')
																<a href="{{ route('site.forecast.show', ['forecast' => $record['id']]) }}"><strong>{{ $record['team1'] }} - {{ $record['team2'] }}</strong></a>
																@break;

															@default
																<strong>{{ $record['team1'] }} - {{ $record['team2'] }}</strong>
																@break;
														@endswitch
													</div>

													<div class="mb-2">
														{{ $record['tournament'] }}
														@if (false === mb_strpos(mb_strtolower($record['tournament']), mb_strtolower($record['stage'])))
															{{ $record['stage'] }}
														@endif
													</div>

													<div class="mb-2">
														<div>{{ $record['outcometype'] }}</div>
														<div>{{ $record['outcomescope'] }}</div>
														<div>{{ $record['outcomesubtype'] }}</div>
													</div>

													<div class="mb-2">
														<div>К: {{ $record['rate'] }}</div>
														<div>Ставка: {{ $record['bet'] }} баллов</div>
														<div>Статус: <span class="post-status-{{ $record['status_slug'] }}">{{ $record['status_name'] }}<span></div>
													</div>
												</div>
											</div>
										@endforeach
									@endforeach
									<div class="post-btns">
										<a class="btn btn-primary btn-sm" href="{{ route('account.forecast.index') }}">Все изменения банка</a>
									</div>
								</div>
							</div>
						@endif
					</div>

					{{--
					<div class="user-link">
						<div class="account-link" id="noticesMenu" data-toggle="dropdown" data-display="static" aria-haspopup="false" aria-expanded="false">
							<span class="icon"><i class="fa fa-bell-o" aria-hidden="true"></i></span>
						</div>
						<div class="dropdown-menu win win-notices" aria-labelledby="noticesMenu">
							<div class="win-cont">
								<div class="post">
									<time>20.01.2020<br>12:30</time>
									<div class="post-text">Поздравляем! Ваш прогноз по матчу <b>Тулуза-Кан, Франция, Лига 1</b> оправдался! Ваш банк пополнен на 500 баллов.</div>
								</div>
								<div class="post">
									<time>20.01.2020<br>12:30</time>
									<div class="post-text">Поздравляем! Ваш прогноз по матчу <b>Тулуза-Кан, Франция, Лига 1</b> оправдался! Ваш банк пополнен на 500 баллов.</div>
								</div>
								<div class="post">
									<time>20.01.2020<br>12:30</time>
									<div class="post-text">Пользователь <b>Сосиска</b> ответил на Ваш <a href="#">комментарий</a>: <em>только цифра другая какая-то должна быть</em></div>
								</div>
								<div class="post">
									<time>20.01.2020<br>12:30</time>
									<div class="post-text">Ваша статья <a href="#">Рибери отказался пожать руку Ковачу после замены в матче с «Гертой»</a> одобрена модератором.</div>
								</div>
								<div class="post-btns">
									<a class="btn btn-primary btn-sm" href="#">Все уведомления</a>
								</div>
							</div>
						</div>
					</div>
					--}}

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
							<span class="a-content">{{ Auth::user()->nick_name }}</span>
						</div>

						<div class="dropdown-menu win win-account" aria-labelledby="accountMenu">
							<div class="win-cont">
								<h3>Личный кабинет</h3>
								<div class="win-account-name d-flex align-items-center">
									<div class="user-img">
										<img src="{{ asset('preview/48/48/storage/users/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->nickname }}">
									</div>
									<div class="win-user-name">
										<h4>{{ Auth::user()->nickname }}</h4>
										<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
										<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
											{{ csrf_field() }}
										</form>
									</div>
								</div>
								<div class="win-account-bank">{{ Auth::user()->balance }} {{ Lang::choice('балл|балла|баллов', Auth::user()->balance, [], 'ru') }}</div>

								<ul class="navi">
									<li><a href="{{ route('account.dashboard.index') }}" class="nav-link">Моя статистика</a></li>
									{{--<li class="dropdown-divider"></li>--}}
									{{--<li><a href="#" class="nav-link">Мои комментарии</a><span class="bagde-gray">12345</span></li>--}}
									{{--<li><a href="#" class="nav-link">Ответы</a><span class="badge badge-success">2</span></li>--}}
									<li class="dropdown-divider"></li>
									<li><a href="{{ route('account.forecast.index') }}" class="nav-link">Мои прогнозы</a> <a href="{{ route('account.forecast.create') }}" class="btn btn-primary btn-sm">сделать прогноз</a> <span class="bagde-gray">{{ Auth::user()->stat_forecasts }}</span></li>
									<li><a href="{{ route('account.post.index') }}" class="nav-link">Мои статьи</a> <a class="btn btn-primary btn-sm" href="{{ route('account.post.create') }}">опубликовать статью</a> <span class="bagde-gray">{{ Auth::user()->stat_posts }}</span></li>
									<li><a href="{{ route('account.brief.index') }}" class="nav-link">Мои новости</a> <a class="btn btn-primary btn-sm" href="{{ route('account.brief.create') }}">опубликовать</a> <span class="bagde-gray">{{ Auth::user()->stat_briefs }}</span></li>
									<li class="dropdown-divider"></li>
									<li><a href="{{ route('account.personal.index') }}" class="nav-link">Изменение личных данных</a></li>
									<li><a href="{{ route('account.password.index') }}" class="nav-link">Изменение пароля</a></li>
									<li><a href="{{ route('account.social.index') }}" class="nav-link">Настройка авторизации</a></li>
									{{--<li><a href="{{ route('account.notice.index') }}" class="nav-link">Настройка уведомлений</a></li>--}}
									{{--<li><a href="{{ route('account.event.index') }}" class="nav-link">Последняя активность</a></li>--}}
									{{--<li><a href="#" class="nav-link">Уведомления</a><span class="badge badge-success">2</span></li>--}}
									{{--<li class="dropdown-divider"></li>--}}
									{{--<li><a href="#" class="nav-link">Мои обращения</a><span class="bagde-gray">1</span></li>--}}
									{{--<li><a class="btn btn-light" href="#">Задать вопрос</a></li>--}}
									<li class="dropdown-divider"></li>
									<li>
										<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
    		@endif

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
                					<li class="nav-item"><a class="link" href="{{ route('site.brief.index') }}">Новости</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.post.index') }}">Статьи</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.match.index') }}">Матч-центр</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.forecast.index') }}">Прогнозы</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.bookmaker.index') }}">Букмекеры</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.deal.index') }}">Акции</a></li>
                					<li class="nav-item"><a class="link" href="{{ route('site.user.index') }}">Капперы</a></li>
                				</ul>
							</div>
							@if ($menusections->count())
            					<div class="col-md-4">
                    	        	<ul class="nav flex-column">
                    	        		@foreach($menusections as $menusection)
                    	        			@if ($menusection->menuitems->count())
                            					<li class="nav-item">
                            						<a class="link" href="{{ $menusection->url }}">{{ $menusection->name }}</a>
                                   	            	<ul class="d-md-none">
                                   	            		@foreach($menusection->menuitems as $menuitem)
                                    						<li class="nav-item"><a href="{{ $menuitem->url }}">{{ $menuitem->name }}</a></li>
														@endforeach
                               						</ul>
                            					</li>
                            				@else
		                            			<li class="nav-item"><a class="link" href="{{ $menusection->url }}">{{ $menusection->name }}</a></li>
                            				@endif
										@endforeach
                    	        	</ul>
            					</div>
            				@endif
            				<div class="col-md-4">
                    	    	<ul class="nav flex-column">
                					<li class="nav-item"><a href="{{ route('site.about.index') }}">О проекте</a></li>
                					<li class="nav-item"><a href="{{ route('site.contact.index') }}">Контакты</a></li>
                					<li class="nav-item"><a href="{{ route('site.help.index') }}">Справка</a></li>
                					{{--<li class="nav-item"><a href="{{ route('site.help.ask') }}">Задать вопрос</a></li>--}}
                					<li class="nav-item"><a href="{{ route('site.legal.show', ['document' => 'rules']) }}">Правила сайта</a></li>
                    	    	</ul>
							</div>
						</div>
					</div>
            	</div>
			</div>
		</div>
	</div>

	@if ($menusections->count())
		<div class="nav-box">
			<ul class="nav nav-fill menu">
				@foreach($menusections as $menusection)
					@if ($menusection->menuitems->count())
						<li class="nav-item menu-item">
							<a class="nav-link dropdown-toggle" href="{{ $menusection->url ?? '#' }}">{{ $menusection->name }}</a>
        	            	<div class="win-nav win-menu">
            	        		<div class="win-cont">
                           	    	<ul>
                	       	    		@foreach($menusection->menuitems as $menuitem)
	                	        			<li class="nav-item"><a href="{{ $menuitem->url }}">{{ $menuitem->name }}</a></li>
										@endforeach
	               	   				</ul>
								</div>
        	            	</div>
						</li>
					@else
						<li class="nav-item"><a class="nav-link" href="{{ $menusection->url }}">{{ $menusection->name }}</a></li>
					@endif
				@endforeach
			</ul>
		</div>
	@endif

</header>
