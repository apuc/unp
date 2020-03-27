<div class="card article-card">
	<div class="card-header">
		<span class="name"><a href="{{ route('site.post.index') }}">Статьи</a> / <a href="{{ route('site.post.index', ['sport' => $post->sport->slug ]) }}">{{ $post->sport->name }}</a></span>
		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
	</div>
	<div class="card-body">
		<a href="{{ route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)]) }}" class="card-image-top">
			<img src="{{ asset('preview/502/300/storage/posts/' . $post->picture) }}" alt="{{ $post->name }}">
		</a>
		<h3><a href="{{ route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)]) }}">{{ $post->name }}</a></h3>
		<div class="card-text">
			<p>{{ $post->announce }}</p>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<a href="{{ route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)]) }}#post-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $post->postcomments_count }}</a>
		</div>
		<div class="card-user">
			<div class="user-name">
				<a href="{{ route('site.user.show', ['login' => $post->user->login]) }}">{{ $post->user->nickname }}</a>
				<time>{{ $post->posted_at->format('d.m.Y H:i') }}</time>
			</div>
			<div class="user-img">
				<a href="{{ route('site.user.show', ['login' => $post->user->login]) }}">
					<img src="{{ asset('preview/33/33/storage/users/' . $post->user->avatar) }}" alt="{{ $post->user->nickname }}">
				</a>
			</div>
		</div>
	</div>
</div>
