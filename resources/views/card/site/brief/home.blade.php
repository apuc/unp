<div class="card briefs-card">
	<div class="card-body">
		<time>{{ $brief->posted_at->format('H:i') }}<span class="date">{{ $brief->posted_at->format('d.m.Y') }}</span></time>
		@if (null !== $brief->sport->icon)
			<div class="sport-icon"><img src="{{ asset('storage/sports/' . $brief->sport->icon) }}" alt="{{ $brief->sport->name }}"></div>
		@endif
		<p>
			<a href="{{ route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)]) }}">{{ $brief->name }}</a>
			@if (null !== $brief->picture)
				<span class="badge badge-secondary">фото</span>
			@endif
			@if ($brief->briefcomments_count > 0)
				<a href="{{ route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)]) }}#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i>{{ $brief->briefcomments_count }}</a>
			@endif
		</p>
	</div>
</div>