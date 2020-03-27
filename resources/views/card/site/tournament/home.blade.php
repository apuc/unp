<div class="card tournament-card">
	<div class="card-body">
		@foreach ($sports as $sport)
			<h5>
				<a href="{{ route('site.match.index', ['sport' => $sport->slug]) }}">
					<span class="sport-icon"><img src="{{ asset('preview/24/24/storage/sports/' . $sport->icon) }}" alt="{{ $sport->name }}"></span>{{ $sport->name }}</a>
			</h5>
			<ul>
				@foreach (
					$sport->tournaments->filter(function ($record) {
						return $record->o == 0;
					}) as $tournament
				)
					<li>
						<a href="{{ route('site.match.index', ['tournament' => $tournament->id]) }}">
							<span class="b-matches__tournament-flag"><img src="{{ asset('preview/40/40/storage/tournaments/' . $tournament->logo) }}" alt="{{ $tournament->name }}"></span>
							{{ $tournament->name }}
						</a>
					</li>
				@endforeach

				@foreach (
					$sport->tournaments->filter(function ($record) {
						return $record->o == 1;
					})->slice(0, 6) as $tournament
				)
					<li>
						<a href="{{ route('site.match.index', ['tournament' => $tournament->id]) }}">
							<span class="b-matches__tournament-flag"><img src="{{ asset('preview/40/40/storage/tournaments/' . $tournament->logo) }}" alt="{{ $tournament->name }}"></span>
							{{ $tournament->name }}
						</a>
					</li>
				@endforeach
			</ul>
		@endforeach
	</div>
</div>
