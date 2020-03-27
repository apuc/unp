<div class="card news-card">
	<div class="card-header">
		<span class="name"><a href="{{ route('site.brief.index') }}">Новости</a> / <a href="{{ route('site.brief.index', ['sport' => $brief->sport->slug ]) }}">{{ $brief->sport->name }}</a></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<a href="{{ route('account.brief.edit', ['brief_id' => $brief->id]) }}" class="card-image-top">
			<img src="{{ asset('preview/512/223/storage/briefs/' . $brief->picture) }}" alt="{{ $brief->name }}">
		</a>
		<h3><a href="{{ route('account.brief.edit', ['brief_id' => $brief->id]) }}">{{ $brief->name }}</a></h3>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			@if ($brief->briefstatus->slug == 'confirmed')
				<a href="{{ route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)]) }}#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $brief->briefcomments_count }}</a>
			@endif
		</div>
		<div class="card-user">
			<div class="user-name">
				<span class="text-uppercase">{{ $brief->briefstatus->name }}</span>
				<time>{{ $brief->posted_at->format('d.m.Y H:i') }}</time>
			</div>
			<div class="user-img">
				<img src="{{ asset('preview/200/200/storage/users/' . $brief->user->avatar) }}" alt="{{ $brief->user->nickname }}">
			</div>
		</div>
	</div>
</div>