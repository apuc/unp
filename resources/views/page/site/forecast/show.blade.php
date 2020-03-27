@extends('layout.site.grid.double')

@section('content')
	<div class="card card-detail forecasts-detail forecasts-detail--{{ $forecast->forecaststatus->slug }}" id="description">
		<div class="card-header">
			<span class="name"><a href="{{ route('site.forecast.index') }}">Прогнозы</a> / <a href="{{ route('site.forecast.index', ['sport' => $forecast->sport->slug]) }}">{{ $forecast->sport->name }}</a></span>
			{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
		</div>
		<div class="card-body">
			<div class="forecasts-detail__participants">
				<div class="forecasts-detail__participant">
					@if (null !== $forecast->match->participants[0]->team->logo)
						<div class="forecasts-detail__participant-img">
							<img src="{{ asset('preview/100/100/storage/teams/' . $forecast->match->participants[0]->team->logo) }}" alt="{{ $forecast->match->participants[0]->team->name }}">
						</div>
					@endif
					<h3>{{ $forecast->match->participants[0]->team->name }}</h3>
   				</div>

				<div class="forecasts-detail__score">
					@if (in_array($forecast->match->matchstatus->slug, ['finished', 'inprogress']))
   						<div class="forecasts-detail__score-1">{{ $forecast->match->participants[0]->score }}</div>
   						<div class="forecasts-detail__score-2">{{ $forecast->match->participants[1]->score }}</div>
   					@endif
				</div>

				<div class="forecasts-detail__participant">
					@if (null !== $forecast->match->participants[1]->team->logo)
						<div class="forecasts-detail__participant-img">
							<img src="{{ asset('preview/100/100/storage/teams/' . $forecast->match->participants[1]->team->logo) }}" alt="{{ $forecast->match->participants[1]->team->name }}">
						</div>
					@endif
					<h3>{{ $forecast->match->participants[1]->team->name }}</h3>
   				</div>
			</div>

			<div class="forecasts-detail__hd">
				<p class="text-uppercase">
					<span>{{ $forecast->match->stage->season->tournament->name }}</span>
					&mdash;
					<span>{{ $forecast->match->stage->season->name }}</span>
					@if (false === mb_strpos(mb_strtolower($forecast->match->stage->season->tournament->name), mb_strtolower($forecast->match->stage->name)))
						&mdash;
						<span>{{ $forecast->match->stage->name }}</span>
					@endif
				</p>
				<p>Начало игры: {{ $forecast->match->started_at->format('d.m.Y H:i') }}</p>
			</div>

			<div class="forecasts-detail__val">
    			<div class="forecasts-detail__val-item">
    				Исход:
    				<b>{{ $forecast->outcometype->name }}</b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Время:
    				<b>{{ $forecast->outcomescope->name }}</b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Прогноз:
    				<b>{{ parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name]) }}</b>
    			</div>
    			
    			<div class="forecasts-detail__val-item">
    				Ставка:
    				<b>{{ $forecast->bet }} баллов</b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Букмекер:
        			<a href="{{ $forecast->bookmaker->site }}" class="bookmaker" target="_blank" rel="nofollow">
        				@if (null !== $forecast->bookmaker->logo)
        					<img src="{{ asset('preview/64/26/storage/bookmakers/' . $forecast->bookmaker->logo) }}" alt="{{ $forecast->bookmaker->name }}">
        				@else
        					{{ $forecast->bookmaker->name }}
        				@endif
        			</a>
				</div>
    			<div class="forecasts-detail__val-item">
    				Коэффициент:
                	<b>{{ $forecast->rate }}</b>
				</div>
                <div class="forecasts-detail__val-item">
    				Результат:
                	<div class="result">{{ $forecast->forecaststatus->name }}</div>
                </div>
			</div>
			@if (null !== $forecast->description)
				<div class="forecasts-detail__comment">
					<p>{!! nl2br($forecast->description) !!}</p>
				</div>
			@endif

			<div class="share-with">
				<p>Поделиться прогнозом</p>
				@include('partial.site.share')
			</div>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				<a href="{{ route('site.forecast.show', ['forecast' => $forecast->id]) }}#comment" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $forecast->forecastcomments_count }}</a>
			</div>
			<div class="card-user">
				<div class="user-name">
					<a href="{{ route('site.user.show', ['login' => $forecast->user->login]) }}">{{ $forecast->user->nickname }}</a>
					<time>{{ $forecast->posted_at->format('d.m.Y H:i') }}</time>
				</div>
				<div class="user-img"><a href="{{ route('site.user.show', ['login' => $forecast->user->login]) }}"><img src="{{ asset('preview/33/33/storage/users/' . $forecast->user->avatar) }}" alt="{{ $forecast->user->nickname}}"></a></div>
			</div>
		</div>
	</div>

	@if (!Auth::guest())
		<div id="your-comment" class="card-wrap">
			<h2 class="title">ВАШ КОММЕНТАРИЙ</h2>
			<form action="{{ route('site.forecast.comment', ['forecast' => $forecast->id]) }}" method="post">
				{{ csrf_field() }}
				<textarea name="message" class="form-control" placeholder="введите текст комментария"></textarea>
				<div class="btn-more-box">
					<button type="submit" class="btn btn-primary pl-4 pr-4">Отправить</button>
				</div>
			</form>
		</div>
	@endif

	@if ($forecast->forecastcomments->count())
		<div class="card-wrap" id="comment">
			<h2 class="title">КОММЕНТАРИИ <span>{{ $forecast->forecastcomments_count }}</span></h2>

			@foreach ($forecast->forecastcomments as $forecastcomment)
				@include('card.site.forecastcomment.normal', [
					'forecastcomment' => $forecastcomment,
				])
			@endforeach

			{{--
			<div class="btn-more-box">
				<a href="#" class="btn btn-more">Еще комментарии</a>
			</div>
			--}}
		</div>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.forecast')
@endsection


