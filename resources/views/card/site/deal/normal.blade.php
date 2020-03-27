<div class="card deals-card">
	<div class="card-header">
		<span class="name"><a href="{{ route('site.deal.index') }}">Акции</a> / <a href="{{ route('site.bookmaker.show', ['bookmaker' => $deal->bookmaker->slug]) }}">{{ $deal->bookmaker->name }}</a></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<a class="deals-card__link" href="{{ $deal->url }}" target="_blank" rel="nofollow">
			<div class="deals-card__image">
				<img src="{{ asset('preview/222/180/storage/deals/' . $deal->cover) }}" alt="{{ $deal->name }}">
			</div>
			<div class="deals-card__title">{{ $deal->name }}</div>
		</a>
	</div>
	<div class="card-footer">
		<a class="btn btn-light" href="{{ route('site.deal.show', ['deal' => $deal->id]) }}">Подробнее</a>
		<a class="btn btn-light" href="{{ $deal->url }}" target="_blank" rel="nofollow">Участвовать</a>
	</div>
</div>
