<article class="card legal-document">
	<h3><a href="{{ route('site.legal.show', ['document' => $slug]) }}">{{ $name }}</a></h3>
	<time datetime="{{ $issued_at->format('Y-m-d') }}">@lang('message.site.legal.edition', ['issued_at' => Moment::asDate($issued_at)])</time>
</article>
