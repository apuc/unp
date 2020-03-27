<div class="card news-card">
	<div class="card-header">
		<span class="name"><a href="{{ route('site.post.index') }}">Статьи</a> / <a href="{{ route('site.post.index', ['sport' => $post->sport->slug ]) }}">{{ $post->sport->name }}</a></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<a href="{{ route('account.post.edit', ['post_id' => $post->id]) }}" class="card-image-top">
			<img src="{{ asset('preview/512/223/storage/posts/' . $post->picture) }}" alt="{{ $post->name }}">
		</a>
		<h3><a href="{{ route('account.post.edit', ['post_id' => $post->id]) }}">{{ $post->name }}</a></h3>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			@if ($post->poststatus->slug == 'confirmed')
				<a href="{{ route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)]) }}#post-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $post->postcomments_count }}</a>
			@endif
		</div>
		<div class="card-user">
			<div class="user-name">
				<span class="text-uppercase">{{ $post->poststatus->name }}</span>
				<time>{{ $post->posted_at->format('d.m.Y H:i') }}</time>
			</div>
			<div class="user-img">
				<img src="{{ asset('preview/33/33/storage/users/' . $post->user->avatar) }}" alt="{{ $post->user->nickname }}">
			</div>
		</div>
	</div>
</div>

