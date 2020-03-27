@extends('layout.site.grid.double')

@section('content')
	<div id="description" class="card card-detail">
		<div class="card-header">
			<span class="name"><a href="{{ route('site.brief.index') }}">Статьи</a> / <a href="{{ route('site.brief.index', ['sport' => $brief->sport->slug ]) }}">{{ $brief->sport->name }}</a></span>
			{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
		</div>
		<div class="card-body">
			@if (null !== $brief->picture)
				<figure class="text-center">
					<img class="img-fluid" src="{{ asset('preview/807/449/storage/briefs/' . $brief->picture) }}" alt="">
					@isset($brief->picture_author)
						<figcaption class="figure-caption text-center">ФОТО: {{ $brief->picture_author }}</figcaption>
					@endisset
				</figure>
			@endif

			{!! $brief->content !!}

			<div class="share-with">
				<p>Поделиться  новостью</p>
				@include('partial.site.share')
			</div>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				<a href="{{ route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)]) }}#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> {{ $brief->briefcomments_count }}</a>
			</div>
			<div class="card-user">
				<div class="user-name">
					<a href="{{ route('site.user.show', ['login' => $brief->user->login]) }}">{{ $brief->user->nickname }}</a>
					<time>{{ $brief->posted_at->format('d.m.Y H:i') }}</time>
				</div>
				<div class="user-img">
					<a href="{{ route('site.user.show', ['login' => $brief->user->login]) }}">
						<img src="{{ asset('preview/33/33/storage/users/' . $brief->user->avatar) }}" alt="{{ $brief->user->nickname }}">
					</a>
				</div>
			</div>
		</div>
	</div>

	@if (!Auth::guest())
		<div id="brief-comment" class="card-wrap">
			<h2 class="title">ВАШ КОММЕНТАРИЙ</h2>
			<form action="{{ route('site.brief.comment', ['brief' => URI::asSlug($brief->id, $brief->name)]) }}" method="post">
				{{ csrf_field() }}
				<textarea name="message" class="form-control" placeholder="введите текст комментария"></textarea>
				<div class="btn-more-box">
					<button type="submit" class="btn btn-primary pl-4 pr-4">Отправить</button>
				</div>
			</form>
		</div>
	@endif

	@if ($brief->briefcomments->count())
		<div id="brief-comments" class="card-wrap">
			<h2 class="title">КОММЕНТАРИИ <span>{{ $brief->briefcomments_count }}</span></h2>

			@foreach ($brief->briefcomments as $briefcomment)
				@include('card.site.briefcomment.normal', [
					'briefcomment' => $briefcomment,
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
	@include('partial.site.sidebar.brief')
@endsection