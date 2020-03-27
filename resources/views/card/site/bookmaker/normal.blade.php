<a class="card bookmaker-card" href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}">
	<div class="card-header">
		<span class="name"><object><a href="{{ route('site.bookmaker.index') }}">Букмекеры</a></object> / <object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}">{{ $bookmaker->name }}</a></object></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<div class="bookmaker-header">
			<div class="bookmaker-logo">
				<object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}"><img src="{{ asset('preview/512/223/storage/bookmakers/' . $bookmaker->logo) }}" alt="{{ $bookmaker->name }}"></a></object>	
			</div>
			<div class="bookmaker-name"><object><a href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}">{{ $bookmaker->name }}</a></object></div>
		</div>
		@if ($bookmaker->bonus > 0)
			<div class="bookmaker-bonus">Бонус <b>{{ $bookmaker->bonus }} рублей</b></div>
		@endif
	</div>
	<div class="card-footer">
		<object><a class="btn btn-light" href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}">Обзор</a></object>
		<object><a class="btn btn-light" href="{{ $bookmaker->site }}" target="_blank" rel="nofollow">Сайт</a></object>
	</div>
</a>
