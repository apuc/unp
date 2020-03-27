@extends('layout.site.grid.double')

@section('content')
	<div id="description" class="card card-detail">
		<div class="card-header">
			<span class="name"><a href="{{ route('site.post.index') }}">Статьи</a> / <a href="{{ route('site.post.index', ['sport' => $post->sport->slug ]) }}">{{ $post->sport->name }}</a></span>
			{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
		</div>
		<div class="card-body">
			<figure class="text-center">
				<img class="img-fluid" src="{{ asset('preview/782/435/storage/posts/' . $post->picture) }}" alt="">
				@isset($post->picture_author)
					<figcaption class="figure-caption text-center">ФОТО: {{ $post->picture_author }}</figcaption>
				@endisset
			</figure>

			{!! $post->content !!}

			<div class="share-with">
				<p>Поделиться статьей</p>
				@include('partial.site.share')
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

	@if (!Auth::guest())
		<div id="post-comment" class="card-wrap">
			<h2 class="title">ВАШ КОММЕНТАРИЙ</h2>
			<form action="{{ route('site.post.comment', ['post' => URI::asSlug($post->id, $post->name)]) }}" method="post">
				{{ csrf_field() }}
				<textarea name="message" class="form-control" placeholder="введите текст комментария"></textarea>
				<div class="btn-more-box">
					<button type="submit" class="btn btn-primary pl-4 pr-4">Отправить</button>
				</div>
			</form>
		</div>
	@endif

	@if ($post->postcomments->count())
		<div id="post-comments" class="card-wrap">
			<h2 class="title">КОММЕНТАРИИ <span>{{ $post->postcomments_count }}</span></h2>

			@foreach ($post->postcomments as $postcomment)
				@include('card.site.postcomment.normal', [
					'postcomment' => $postcomment,
				])
			@endforeach

			{{--
			<div class="btn-more-box">
				<a href="#" class="btn btn-more">Еще комментарии</a>
			</div>
			--}}
		</div>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.post')
@endsection