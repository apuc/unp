<a href="{{ route('site.forecast.show', ['forecast' => $forecast->id]) }}" class="card forecast-card forecast-card--{{ $forecast->forecaststatus->slug }}">
	<div class="card-header">
		<span class="name"><object><a href="{{ route('site.forecast.index') }}">Прогнозы</a></object> / <object><a href="{{ route('site.forecast.index', ['sport' => $forecast->sport->slug]) }}">{{ $forecast->sport->name }}</a></object></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<div class="card-subtitle">
			<span>{{ $forecast->match->stage->season->tournament->name }}</span>
			@if (false === mb_strpos(mb_strtolower($forecast->match->stage->season->tournament->name), mb_strtolower($forecast->match->stage->name)))
				&mdash;
				<span>{{ $forecast->match->stage->name }}</span>
			@endif
		</div>
		<div class="forecast-card__participants">
			<div class="forecast-card__participant">
				<h4>{{ $forecast->match->participants[0]->team->name }}</h4>
				@if (null !== $forecast->match->participants[0]->team->logo)
					<img src="{{ asset('preview/30/30/storage/teams/' . $forecast->match->participants[0]->team->logo) }}" alt="{{ $forecast->match->participants[0]->team->name }}">
				@endif
			</div>
			<div class="forecast-card__score">
				@if (in_array($forecast->match->matchstatus->slug, ['finished', 'inprogress']))
					<span class="forecast-card__score-1">{{ $forecast->match->participants[0]->score }}</span> -
					<span class="forecast-card__score-2">{{ $forecast->match->participants[1]->score }}</span>
				@else
					<span class="forecast-card__score-1">?</span> -
					<span class="forecast-card__score-2">?</span>
				@endif
			</div>
			<div class="forecast-card__participant">
				@if (null !== $forecast->match->participants[1]->team->logo)
					<img src="{{ asset('preview/30/30/storage/teams/' . $forecast->match->participants[1]->team->logo) }}" alt="{{ $forecast->match->participants[1]->team->name }}">
				@endif
				<h4>{{ $forecast->match->participants[1]->team->name }}</h4>
			</div>
		</div>
		<div>
			<time>{{ $forecast->match->started_at->format('d.m.Y H:i') }}</time>
		</div>
		<div class="forecast-card__val">
			<div class="sm"><b>{{ $forecast->outcometype->name }}</b></div>
			<div class="sm">{{ $forecast->outcomescope->name }}</div>
			<div class="bold prognosis">{{ parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name]) }}</div>
			
			<div class="bold rate">{{ $forecast->bet }} баллов</div>
			<object><a href="{{ $forecast->bookmaker->site }}" class="bookmaker" target="_blank" rel="nofollow">
				@if (null !== $forecast->bookmaker->logo)
					<img src="{{ asset('preview/64/26/storage/bookmakers/' . $forecast->bookmaker->logo) }}" alt="{{ $forecast->bookmaker->name }}">
				@else
					{{ $forecast->bookmaker->name }}
				@endif
			</a></object>
            <div class="odds"><span class="badge badge-light">К: {{ $forecast->rate }}</span></div>
            <div class="result">
            	@if ($forecast->forecaststatus->slug == 'confirmed') 
            		&nbsp;
            	@else
            		{{ $forecast->forecaststatus->name }}
            	@endif
            </div>
		</div>
		<div class="forecast-btn">
			<object><a class="btn btn-more" href="{{ route('site.forecast.show', ['forecast' => $forecast->id]) }}">Подробнее</a></object>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<object><a class="btn btn-light" href="{{ route('site.forecast.show', ['forecast' => $forecast->id]) }}">Подробнее</a></object>
			<object><a href="{{ route('site.forecast.show', ['forecast' => $forecast->id]) }}#comment" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $forecast->forecastcomments_count }}</a></object>
		</div>
		<div class="card-user">
			<div class="user-name">
				<object><a href="{{ route('site.user.show', ['login' => $forecast->user->login]) }}">{{ $forecast->user->nickname }}</a></object>
				<time>{{ $forecast->posted_at->format('d.m.Y H:i') }}</time>
			</div>
			<div class="user-img"><object><a href="{{ route('site.user.show', ['login' => $forecast->user->login]) }}"><img src="{{ asset('preview/33/33/storage/users/' . $forecast->user->avatar) }}" alt="{{ $forecast->user->nickname }}"></a></object></div>
		</div>
	</div>
</a>