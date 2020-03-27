@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap">
   		<h2 class="title">Мой аккаунт</h2>
   		<div class="row my-account">
   			<div class="col-12 col-md-6">
   				@if (!is_null(Auth::user()->name))
					<div class="form-group row">
						<label for="name" class="col-md-3 col-form-label">Имя</label>
						<div class="col-md-9">
							<input type="text" id="name" class="form-control" placeholder="{{ Auth::user()->name }}" disabled>
						</div>
					</div>
				@endif
   				<div class="form-group row">
					<label for="login" class="col-md-3 col-form-label">Логин</label>
					<div class="col-md-9">
						<input type="text" id="login" class="form-control" placeholder="{{ Auth::user()->login }}" disabled>
					</div>
				</div>
   				<div class="form-group row">
					<label for="email" class="col-md-3 col-form-label">E-mail</label>
					<div class="col-md-9">
						<input type="email" id="email" class="form-control" placeholder="{{ Auth::user()->email }}" disabled>
					</div>
				</div>
   				@if (!is_null(Auth::user()->phone))
					<div class="form-group row">
						<label for="phone" class="col-md-3 col-form-label">Телефон</label>
						<div class="col-md-9">
							<input type="text" id="phone" class="form-control" placeholder="{{ Morph::phone(Auth::user()->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d') }}" disabled>
						</div>
					</div>
				@endif
   			</div>

   			<div class="col-12 col-md-6 text-center">
   				<div class="form-group">
   					<a class="btn btn-primary btn-account" href="{{ route('account.password.index') }}">Сменить пароль</a>
   				</div>
   				<div class="form-group">
   					<a class="btn btn-primary btn-account" href="{{ route('account.personal.index') }}">Исправить личные данные</a>
   				</div>
   				<div class="form-group">
   					<a class="btn btn-primary btn-account" href="{{ route('account.social.index') }}">Настроить вход через соцсети</a>
   				</div>
   			</div>

   			@if (null !== \Auth::user()->about)
				<div class="col-12">
					<div class="form-group row">
						<label for="name" class="col-md-12 col-form-label">О себе</label>
						<div class="col-md-12">
							{!! nl2br(e(\Auth::user()->about)) !!}
						</div>
					</div>
				</div>
			@endif
   		</div>
	</div>

	<div class="card-wrap">
   		<h2 class="title">Прогнозы</h2>
   		<div class="row my-step">
   			<div class="col-auto">
   				<div class="hd">Всего</div>
   				<div class="status">{{ $forecast->all_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Новых</div>
   				<div class="status">{{ $forecast->new_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Выиграло</div>
   				<div class="status">{{ $forecast->win_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Проиграло</div>
   				<div class="status">{{ $forecast->lose_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Отклонено</div>
   				<div class="status">{{ $forecast->declined_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Черновиков</div>
   				<div class="status">{{ $forecast->draft_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Банк, КР</div>
   				<div class="status">{{ Auth::user()->balance }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Ср. коэф</div>
   				<div class="status">{{ sprintf("%0.02f", $forecast->odds_avg) }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Ср. ставка</div>
   				<div class="status">{{ sprintf("%0.02f", $forecast->bet_avg) }}</div>
   			</div>
   			{{--
   			<div class="col-auto">
   				<div class="hd">ROI</div>
   				<div class="status"></div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Проход</div>
   				<div class="status"></div>
   			</div>
   			--}}
   		</div>

   		<div class="row btn-account-row">
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.forecast.index') }}">Все мои прогнозы</a>
   			</div>
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.forecast.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Сделать прогноз</a>
   			</div>
   		</div>
	</div>

	<div class="card-wrap">
   		<h2 class="title">Статьи</h2>
   		<div class="row my-step">
   			<div class="col-auto">
   				<div class="hd">Всего</div>
   				<div class="status">{{ $post->all_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Опубликовано</div>
   				<div class="status">{{ $post->confirmed_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Отклонено</div>
   				<div class="status">{{ $post->declined_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Черновиков</div>
   				<div class="status">{{ $post->draft_count }}</div>
   			</div>
   		</div>

   		<div class="row btn-account-row">
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.post.index') }}">Все мои статьи</a>
   			</div>
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.post.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Опубликовать статью</a>
   			</div>
   		</div>
	</div>

	<div class="card-wrap">
   		<h2 class="title">Новости</h2>
   		<div class="row my-step">
   			<div class="col-auto">
   				<div class="hd">Всего</div>
   				<div class="status">{{ $brief->all_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Опубликовано</div>
   				<div class="status">{{ $brief->confirmed_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Отклонено</div>
   				<div class="status">{{ $brief->declined_count }}</div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Черновиков</div>
   				<div class="status">{{ $brief->draft_count }}</div>
   			</div>
   		</div>

   		<div class="row btn-account-row">
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.brief.index') }}">Все мои новости</a>
   			</div>
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="{{ route('account.brief.create') }}"><i class="fa fa-plus" aria-hidden="true"></i> Опубликовать новость</a>
   			</div>
   		</div>
	</div>

	{{--
	<div class="card-wrap">
   		<h2 class="title">Обращения</h2>
   		<div class="row my-step">
   			<div class="col-auto">
   				<div class="hd">Всего</div>
   				<div class="status"></div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Окрыто</div>
   				<div class="status"></div>
   			</div>
   			<div class="col-auto">
   				<div class="hd">Закрыто</div>
   				<div class="status"></div>
   			</div>
   		</div>

   		<div class="row btn-account-row">
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="#">Все мои вопросы</a>
   			</div>
   			<div class="col-12 col-md-6">
   				<a class="btn btn-primary btn-lg btn-account" href="#">Задать вопрос</a>
   			</div>
   		</div>
	</div>
    --}}

	<div class="card-wrap my-finance">
   		<h2 class="title">Финансы</h2>
   		<div class="row">
   			<div class="col">
    			<div class="btn-group nav nav-pills d-none d-md-flex" role="tablist">
    				<a class="btn btn-secondary" id="today-tab" data-toggle="pill" href="#today" role="tab" aria-controls="today" aria-selected="false">Сегодня</a>
    				<a class="btn btn-secondary" id="yesterday-tab" data-toggle="pill" href="#yesterday" role="tab" aria-controls="yesterday" aria-selected="false">Вчера</a>
    				<a class="btn btn-secondary" id="week-tab" data-toggle="pill" href="#week" role="tab" aria-controls="week" aria-selected="false">Неделя</a>
    				<a class="btn btn-secondary active" id="month-tab" data-toggle="pill" href="#month" role="tab" aria-controls="month" aria-selected="true">Месяц</a>
    				<a class="btn btn-secondary" id="quarter-tab" data-toggle="pill" href="#quarter" role="tab" aria-controls="quarter" aria-selected="false">Квартал</a>
    				<a class="btn btn-secondary" id="year-tab" data-toggle="pill" href="#year" role="tab" aria-controls="year" aria-selected="false">Год</a>
    				<a class="btn btn-secondary" id="all-time-tab" data-toggle="pill" href="#all-time" role="tab" aria-controls="all-time" aria-selected="false">Всё время</a>
    			</div>

        		<select class="form-control select-period d-block d-md-none">
    				<option selected="selected" value="">Сегодня</option>
    				<option value="">Вчера</option>
    				<option value="">Неделя</option>
    				<option value="">Месяц</option>
    				<option value="">Квартал</option>
    				<option value="">Год</option>
    				<option value="">Всё время</option>
        		</select>

			</div>
   			<div class="col-12 col-md-auto ml-md-auto">
   				<div class="calendar-box">
    				<div class="btn btn-secondary dropdown-toggle" id="calendar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					<i class="fa fa-calendar" aria-hidden="true"></i> 7 янв 2018 - 13 мар 2019
    				</div>
    				<div class="dropdown-menu" aria-labelledby="calendar" style="height: 100px;">
    				</div>
				</div>
   			</div>
		</div>

		<div class="tab-content card">
			<div class="tab-pane fade" id="today" role="tabpanel" aria-labelledby="today-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="yesterday" role="tabpanel" aria-labelledby="yesterday-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade show active" id="month" role="tabpanel" aria-labelledby="month-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="quarter" role="tabpanel" aria-labelledby="quarter-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="year" role="tabpanel" aria-labelledby="year-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="all-time" role="tabpanel" aria-labelledby="all-time-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
		</div>
	</div>

	@if ($years->count())
		<div class="card-wrap my-profit">
			<h2 class="title">Прибыль</h2>
			<div class="sort-box mx-auto">
				<span class="sort-box__title">Год</span>
				<div class="sort-box__select">
					<select id="profits" class="form-control">
						@foreach ($years as $year)
							<option value="{{ $year->value }}">{{ $year->value }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div data-ss-profits-content></div>

			<script>
				$(document).ready(function () {
					$('#profits').bind('change', function () {
						ssProfits(
							'{{ route('account.dashboard.profit') }}',
							$(this).val()
						).load();
					});

					$('#profits').trigger('change');
				});
			</script>
		</div>
	@endif
@endsection

{{--
@section('top')
   	<section class="text-top">
		<p>Верхний текст профиля. Целевая аудитория, как принято считать, концентрирует конкурент. В общем, медиапланирование порождает коллективный нишевый проект, полагаясь на инсайдерскую информацию.</p>
   	</section>
@endsection
--}}

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection

{{--
@section('bottom')
   	<section class="text-bottom">
   		<p>Нижнего текст профиля. Целевая аудитория, как принято считать, концентрирует конкурент. В общем, медиапланирование порождает коллективный нишевый проект, полагаясь на инсайдерскую информацию.</p>
   	</section>
@endsection
--}}
