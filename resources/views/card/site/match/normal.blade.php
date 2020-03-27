<div class="card event-card">
	<div class="card-header">
		<span class="name"><a href="{{ route('site.match.index') }}">События</a> / <a href="{{ route('site.match.index', ['sport' => $match->tournament->sport->slug]) }}">{{ $match->tournament->sport->name }}</a></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<div class="card-subtitle"><a href="#">{{ $match->tournament->name }}</a>, <a href="#">{{ $match->season->name }}</a>, <a href="#">{{ $match->stage->name }}</a></div>
		<div class="event-card__teams">
			<div class="team">{{ $match->participants[0]->team->name }}</div>
			<div class="team-result">
				<img src="/temp/logo/patriotas-fs.gif" alt="">
				<div class="result">
					{{ ($match->participants[0]->score ?? '?') }}
					-
					{{ ($match->participants[1]->score ?? '?') }}
				</div>
				<img src="/temp/logo/onse-kaldas.png" alt="">
			</div>
			<div class="team">{{ $match->participants[1]->team->name }}</div>
		</div>
		<div class="event-card__rates rates_list">
			<div class="rate">
				{{ $match->rate1 }}<br>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmaker1->logo) }}" alt="{{ $match->bookmaker1->name }}"></a>
			</div>
			<div class="rate">
				{{ $match->ratex }}<br>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmakerx->logo) }}" alt="{{ $match->bookmakerx->name }}"></a>
			</div>
			<div class="rate">
				{{ $match->rate2 }}<br>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmaker2->logo) }}" alt="{{ $match->bookmaker2->name }}"></a>
			</div>
		</div>
		<div class="event-card__rates rates_tile">
			<div class="rate">
				<div class="rate-val">1<br>{{ $match->rate1 }}</div>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmaker1->logo) }}" alt="{{ $match->bookmaker1->name }}"></a>
			</div>
			<div class="rate">
				<div class="rate-val">x<br>{{ $match->ratex }}</div>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmakerx->logo) }}" alt="{{ $match->bookmakerx->name }}"></a>
			</div>
			<div class="rate">
				<div class="rate-val">2<br>{{ $match->rate2 }}</div>
				<a href="{{ route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $match->bookmaker2->logo) }}" alt="{{ $match->bookmaker2->name }}"></a>
			</div>
		</div>
		<div class="event-btn">
			<a class="btn btn-light" href="{{ route('site.match.show', ['match' => $match->id]) }}">Подробнее</a>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<a class="btn btn-light" href="{{ route('site.match.show', ['match' => $match->id]) }}">Подробнее</a>
			<a href="#" class="card-icon"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 4</a>
			{{--<a href="#" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> 50</a>--}}
		</div>
		<div class="event-date">
			<div class="text-uppercase">{{ $match->matchstatus->name }}</div>
			<div class="date">{{ $match->started_at->format('d.m.Y H:i') }}</div>
		</div>
	</div>
</div>
