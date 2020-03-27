<a href="{{ route('site.match.show', ['match' => $match->id]) }}" class="card event-card">
	<div class="card-header">
		<span class="name"><object><a href="{{ route('site.match.index') }}">События</a></object> / <object><a href="{{ route('site.match.index', ['sport' => $match->stage->season->tournament->sport->slug]) }}">{{ $match->stage->season->tournament->sport->name }}</a></object></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<div class="card-subtitle">
			<span>{{ $match->stage->season->tournament->name }}</span>
			&ndash;
			<span>{{ $match->stage->season->name }}</span>,
			@if (false === mb_strpos(mb_strtolower($match->stage->season->tournament->name), mb_strtolower($match->stage->name)))
				&ndash;
				<span>{{ $match->stage->name }}</span>
			@endif
		</div>
		<div class="event-card__participants">
			<div class="event-card__participant">
				<h4>{{ $match->participants[0]->team->name }}</h4>
				<img src="{{ asset('preview/100/100/storage/teams/' . $match->participants[0]->team->logo) }}" alt="{{ $match->participants[0]->team->name }}">
			</div>
			<div class="event-card__score">
				@if (in_array($match->matchstatus->slug, ['finished', 'inprogress']))
					<span class="event-card__score-1">{{ $match->participants[0]->score }}</span> 
					&ndash;
					<span class="event-card__score-2">{{ $match->participants[1]->score }}</span>
				@else
    				<span class="event-card__score-1">?</span> &ndash; <span class="event-card__score-2">?</span>
				@endif
			</div>
			<div class="event-card__participant">
				<img src="{{ asset('preview/100/100/storage/teams/' . $match->participants[1]->team->logo) }}" alt="{{ $match->participants[1]->team->name }}">
				<h4>{{ $match->participants[1]->team->name }}</h4>
			</div>
		</div>
		<div class="event-card__rates rates_list">
			<div class="rate">
				{{ is_null($match->odds1_current) ? '0.00' : sprintf("%0.02f", $match->odds1_current) }}<br>
				@if (null !== $match->bookmaker1)
					<object><a href="{{ $match->bookmaker1->site }}" target="_blank" rel="nofollow">
						@if (null !== $match->bookmaker1->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmaker1->logo) }}" alt="{{ $match->bookmaker1->name }}">
						@else
							{{ $match->bookmaker1->name }}
						@endif
					</a></object>
				@endif
			</div>
			<div class="rate">
				{{ is_null($match->oddsx_current) ? '0.00' : sprintf("%0.02f", $match->oddsx_current) }}<br>
				@if (null !== $match->bookmakerx)
					<object><a href="{{ $match->bookmakerx->site }}" target="_blank" rel="nofollow">
						@if (null !== $match->bookmakerx->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmakerx->logo) }}" alt="{{ $match->bookmakerx->name }}">
						@else
							{{ $match->bookmakerx->name }}
						@endif
					</a></object>
				@endif
			</div>
			<div class="rate">
				{{ is_null($match->odds2_current) ? '0.00' : sprintf("%0.02f", $match->odds2_current) }}<br>
				@if (null !== $match->bookmaker2)
					<object><a href="{{ $match->bookmaker2->site }}" target="_blank" rel="nofollow">
						@if (null !== $match->bookmaker2->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmaker2->logo) }}" alt="{{ $match->bookmaker2->name }}">
						@else
							{{ $match->bookmaker2->name }}
						@endif
					</a></object>
				@endif
			</div>
		</div>
		<div class="event-card__rates rates_tile">
			<div class="rate">
				<div class="rate-val">1<br>{{ is_null($match->odds1_current) ? '0.00' : sprintf("%0.02f", $match->odds1_current) }}</div>
				@if (null !== $match->bookmaker1)
					<object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug]) }}">
						@if (null !== $match->bookmaker1->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmaker1->logo) }}" alt="{{ $match->bookmaker1->name }}">
						@else
							{{ $match->bookmaker1->name }}
						@endif
					</a></object>
				@endif
			</div>
			<div class="rate">
				<div class="rate-val">x<br>{{ is_null($match->oddsx_current) ? '0.00' : sprintf("%0.02f", $match->oddsx_current) }}</div>
				@if (null !== $match->bookmakerx)
					<object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug]) }}">
						@if (null !== $match->bookmakerx->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmakerx->logo) }}" alt="{{ $match->bookmakerx->name }}">
						@else
							{{ $match->bookmakerx->name }}
						@endif
					</a></object>
				@endif
			</div>
			<div class="rate">
				<div class="rate-val">2<br>{{ is_null($match->odds2_current) ? '0.00' : sprintf("%0.02f", $match->odds2_current) }}</div>
				@if (null !== $match->bookmaker2)
					<object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug]) }}">
						@if (null !== $match->bookmaker2->logo)
							<img src="{{ asset('preview/87/26/storage/bookmakers/' . $match->bookmaker2->logo) }}" alt="{{ $match->bookmaker2->name }}">
						@else
							{{ $match->bookmaker2->name }}
						@endif
					</a></object>
				@endif
			</div>
		</div>
		<div class="event-btn">
			<object><a class="btn btn-light" href="{{ route('site.match.show', ['match' => $match->id]) }}">Подробнее</a></object>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<object><a class="btn btn-light" href="{{ route('site.match.show', ['match' => $match->id]) }}">Подробнее</a></object>
			{{--
			<object><a href="#" class="card-icon"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 4</a></object>
			<object><a href="#" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> 50</a></object>
			--}}
		</div>
		<div class="event-date">
			<div class="text-uppercase">{{ $match->matchstatus->name }}</div>
			<div class="date">{{ $match->started_at->format('d.m.Y H:i') }}</div>
		</div>
	</div>
</a>