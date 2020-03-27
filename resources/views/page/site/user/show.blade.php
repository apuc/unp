@extends('layout.site.grid.double')

@section('content')
    <div class="card card-detail user-detail" id="info">
    	<div class="card-body">
    		<h2>{{ $user->nickname }}</h2>

    		<div class="row align-items-center user-detail-top">
    			<div class="col-4 text-center">
    				<b>На сайте с</b><br>
    				{{ Moment::asDate($user->created_at) }}
    			</div>
    			<div class="col-4 text-center">
    				<div class="user-detail-avatar"><img src="{{ asset('preview/96/96/storage/users/' . $user->avatar) }}" alt="{{ $user->nickname }}"></div>
    			</div>
    			<div class="col-4 text-center">
    				{{--
    				<b>Сейчас</b><br>
    				Оффлайн
    				--}}
    			</div>
    		</div>

    		<div class="row">
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Прогнозов<br><b>{{ $user->stat_forecasts }}</b>
    				</div>
    			</div>
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Комментариев<br><b>{{ $user->stat_comments }}</b>
    				</div>
    			</div>
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Баллов<br><b>{{ $user->balance }}</b>
    				</div>
    			</div>
    			<div class="col-12 col-md-6 text-center">
    				<div class="user-detail-info">
    					Новостей<br><b>{{ $user->stat_briefs }}</b>
    				</div>
    			</div>
    			<div class="col-12 col-md-6 text-center">
    				<div class="user-detail-info">
    					Статей<br><b>{{ $user->stat_posts }}</b>
    				</div>
    			</div>
			</div>
			@if (null !== $user->about)
			<div class="card-text">
				{!! nl2br(e($user->about)) !!}
			</div>
			@endif
    	</div>
    </div>

	<div class="card-wrap user-detail-finance" id="finance">
   		<h2 class="title">Финансы</h2>
		<div class="btn-group nav nav-pills" role="tablist">
			<a class="btn btn-secondary active" id="30-days-tab" data-toggle="pill" href="#30-days" role="tab" aria-controls="today" aria-selected="true">За 30 дней</a>
			<a class="btn btn-secondary" id="all-time-tab" data-toggle="pill" href="#all-time" role="tab" aria-controls="all-time" aria-selected="false">Всё время</a>
		</div>
		<div class="tab-content card">
			<div class="tab-pane fade show active" id="30-days" role="tabpanel" aria-labelledby="30-days-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="all-time" role="tabpanel" aria-labelledby="all-time-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
		</div>
	</div>

	@if ($profits->count())
		<div class="card-wrap" id="profit">
			<h2 class="title">Прибыль</h2>
			<div class="card">
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<tr>
							<th>Период</th>
							<th>Прибыль</th>
							<th>Прогнозов</th>
							<th>Выиграл</th>
							<th>Проиграл</th>
							<th>Отменил</th>
							<th>Средний кэф</th>
							<th>%выигрышей</th>
							<th>ROI</th>
						</tr>
						@foreach ($profits as $month => $profit)
							@if (null !== $profit)
								<tr>
									<td>@lang('months.' . now()->parse($month . '-01')->format('m')) {{ now()->parse($month . '-01')->format('Y') }}</td>
									<td>{{ $profit['profit'] }}%</td>
									<td>{{ $profit['forecasts'] }}</td>
									<td>{{ $profit['wins'] }}</td>
									<td>{{ $profit['losess'] }}</td>
									<td>{{ $profit['draws'] }}</td>
									<td>{{ $profit['offer'] }}</td>
									<td>{{ $profit['luck'] }}%</td>
									<td>{{ $profit['roi'] }}%</td>
								</tr>
							@else
								<tr>
									<td>@lang('months.' . now()->parse($month . '-01')->format('m')) {{ now()->parse($month . '-01')->format('Y') }}</td>
									<td colspan="8" class="text-center">Данных нет</td>
								</tr>

							@endif
						@endforeach
					</table>
				</div>
			</div>
		</div>
	@endif

	@if ($user->forecasts->count())
		<div class="card-wrap" id="forecast">
			<h2 class="title">Последние прогнозы</h2>

			<div class="cards_list d-none d-md-block">
				@foreach ($user->forecasts as $forecast)
					@include('card.site.forecast.normal', [
						'forecast' => $forecast,
					])
				@endforeach
			</div>

			{{-- для мобилы --}}
			<div class="cards_tile d-block d-md-none">
				@foreach ($user->forecasts as $forecast)
					@include('card.site.forecast.normal', [
						'forecast' => $forecast,
					])
				@endforeach
			</div>

		</div>
	@endif

	@if ($user->posts->count())
		<div class="card-wrap" id="publication">
			<h2 class="title">Последние статьи</h2>

			<div class="cards_list d-none d-md-block">
				@foreach ($user->posts as $post)
					@include('card.site.post.normal', [
						'post' => $post,
					])
				@endforeach
			</div>

			{{-- для мобилы --}}
			<div class="cards_tile d-block d-md-none">
				@foreach ($user->posts as $post)
					@include('card.site.post.normal', [
						'post' => $post,
					])
				@endforeach
			</div>
		</div>
	@endif

	@if ($user->briefs->count())
		<div class="card-wrap" id="publication">
			<h2 class="title">Последние новости</h2>

			<div class="cards_list d-none d-md-block">
				@foreach ($user->briefs as $brief)
					@include('card.site.brief.normal', [
						'brief' => $brief,
					])
				@endforeach
			</div>

			{{-- для мобилы --}}
			<div class="cards_tile d-block d-md-none">
				@foreach ($user->briefs as $brief)
					@include('card.site.brief.normal', [
						'brief' => $brief,
					])
				@endforeach
			</div>
		</div>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.user')
@endsection


