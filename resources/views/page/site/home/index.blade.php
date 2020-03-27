@extends('layout.site.app')

@section('columns')
	<section class="home-postings">
		<div class="row">
			<div class="col-12 col-lg-6">
				@if ($posts->count())
					<div class="card-wrap">
						<h2 class="title">Статьи</h2>

						<div class="cards_tile">
							@foreach ($posts as $post)
								@include('card.site.post.home', [
									'post' => $post,
								])
							@endforeach
						</div>
						<div class="btn-more-box">
							<a href="{{ route('site.post.index') }}" class="btn btn-more">Все статьи</a>
						</div>
					</div>
				@endif
			</div>

			<div class="col-12 col-lg-6">
				@if ($briefs->count())
					<div class="card-wrap">
						<h2 class="title">Новости</h2>

						<div class="home-briefs">
							@foreach ($briefs as $brief)
								@include('card.site.brief.home', [
									'brief' => $brief,
								])
							@endforeach
						</div>
						<div class="btn-more-box">
							<a href="{{ route('site.brief.index') }}" class="btn btn-more">Все новости</a>
						</div>
					</div>
				@endif
			</div>
		</div>
	</section>

	@if ($forecasts->count())
		<section class="home-forecasts">
			<div class="row">
				<div class="col-12 col-lg-9">

						<div class="card-wrap">
							<h2 class="title">Новые прогнозы</h2>

							@foreach ($forecasts as $forecast)
								<div class="cards_list">
									@include('card.site.forecast.normal', [
										'forecast' => $forecast
									])
								</div>
							@endforeach

							@foreach ($forecasts as $forecast)
        						<div class="cards_tile">
									@include('card.site.forecast.normal', [
										'forecast' => $forecast
									])
        						</div>
							@endforeach

							<div class="btn-more-box">
								<a href="{{ route('site.forecast.index') }}" class="btn btn-more">Все прогнозы</a>
							</div>
						</div>
				</div>

				@if ($users->count())
					<div class="col-12 col-lg-3">
						<div class="card-wrap">
							<h2 class="title">Лучшие капперы</h2>

							@foreach ($users as $user)
								<div class="user-cards_list">
									@include('card.site.user.home', [
										'user' => $user,
									])
								</div>
							@endforeach

							@foreach ($users as $user)
								<div class="cards_tile">
									@include('card.site.user.normal', [
										'user' => $user,
									])
								</div>
							@endforeach

							<div class="btn-more-box">
								<a href="{{ route('site.user.index') }}" class="btn btn-more">Все капперы</a>
							</div>
						</div>
					</div>
				@endif
			</div>
		</section>
	@endif

	@if ($bookmakers->count())
		<section class="home-bookmakers">
			<div class="row">
				<div class="col-12 col-lg-9">
					<div class="card-wrap">
						<h2 class="title">Лучшие букмекеры</h2>

						@foreach ($bookmakers as $bookmaker)
							<div class="cards_list">
								@include('card.site.bookmaker.normal', [
									'bookmaker' => $bookmaker
								])
							</div>
						@endforeach

						@foreach ($bookmakers as $bookmaker)
							<div class="cards_tile">
								@include('card.site.bookmaker.normal', [
									'bookmaker' => $bookmaker
								])
							</div>
						@endforeach

						<div class="btn-more-box">
							<a href="{{ route('site.bookmaker.index') }}" class="btn btn-more">Все букмекеры</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3">
					<div class="card-wrap home-deals">
						<h2 class="title">Лучшие акции</h2>

						@if ($deals->count())

							@foreach ($deals as $deal)
								<div class="cards_tile">
									@include('card.site.deal.normal', [
										'deal' => $deal
									])
								</div>
							@endforeach

							@foreach ($deals as $deal)
								<div class="cards_list">
									@include('card.site.deal.normal', [
										'deal' => $deal
									])
								</div>
							@endforeach
						@endif

						<div class="btn-more-box">
							<a href="{{ route('site.deal.index') }}" class="btn btn-more">Все акции</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	@endif

	@if ($matches->count())
		<section class="home-events">
			<div class="row">

				<div class="col-12 col-lg-9">
					<div class="card-wrap">
						<h2 class="title">События сегодня</h2>

							@foreach ($matches as $match)
								<div class="cards_list">
									@include('card.site.match.home', [
										'match' => $match,
									])
								</div>
							@endforeach

							<!-- для мобил -->
							@foreach ($matches as $match)
								<div class="cards_tile">
									@include('card.site.match.home', [
										'match' => $match,
									])
								</div>
							@endforeach

							<div class="btn-more-box">
								<a href="{{ route('site.match.index') }}" class="btn btn-more">Все события</a>
							</div>
					</div>
				</div>

				<div class="col-12 col-lg-3">
					<div class="card-wrap">
						<h2 class="title">Турниры сегодня</h2>

						@include('card.site.tournament.home', [
							'sports' => $sports
						])

						<div class="btn-more-box">
							<a href="{{ route('site.match.index') }}" class="btn btn-more">Все турниры</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	@endif

	<section class="text-bottom">
		@include('partial.site.text', [
			'section' => $sitesection,
			'text' => 'bottom'
		])
	</section>

	<div class="b-benefit__list">
		@foreach ($benefits as $benefit)
			@include('card.site.benefit.normal', [
				'benefit' => $benefit
			])
		@endforeach
	</div>

@endsection