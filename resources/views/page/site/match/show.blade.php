@extends('layout.site.grid.double')

@section('content')
	<div class="card event-card matches-detail" id="description">
		<div class="card-header">
			<span class="name"><a href="{{ route('site.match.index') }}">Матчи</a> / <a href="{{ route('site.match.index', ['sport' => $match->stage->season->tournament->sport->slug]) }}">{{ $match->stage->season->tournament->sport->name }}</a></span>
			{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
		</div>
		<div class="card-body text-center">
			<div class="matches-detail__participants">
				<div class="matches-detail__participant">
					@if (null !== $match->participants[0]->team->logo)
						<div class="matches-detail__participant-img">
							<img src="{{ asset('preview/100/100/storage/teams/' . $match->participants[0]->team->logo) }}" alt="{{ $match->participants[0]->team->name }}">
						</div>
					@endif
					<h3>{{ $match->participants[0]->team->name }}</h3>
				</div>

				<div class="matches-detail__score">
					@if (in_array($match->matchstatus->slug, ['finished', 'inprogress']))
   						<div class="matches-detail__score-1">{{ $match->participants[0]->score }}</div>
   						<div class="matches-detail__score-2">{{ $match->participants[1]->score }}</div>
   					@endif
				</div>

				<div class="matches-detail__participant">
					@if (null !== $match->participants[1]->team->logo)
						<div class="matches-detail__participant-img">
							<img src="{{ asset('preview/100/100/storage/teams/' . $match->participants[1]->team->logo) }}" alt="{{ $match->participants[1]->team->name }}">
						</div>
					@endif
					<h3>{{ $match->participants[1]->team->name }}</h3>
				</div>
			</div>
			<p class="text-uppercase">
				<span>{{ $match->stage->season->tournament->name }}</span>
				&mdash;
				<span>{{ $match->stage->season->name }}</span>
				@if (false === mb_strpos(mb_strtolower($match->stage->season->tournament->name), mb_strtolower($match->stage->name)))
					&mdash;
					<span>{{ $match->stage->name }}</span>
				@endif
			</p>
			<p>{{-- Начало игры: через 9 ч. 26 мин.<br>--}}
				{{ Moment::asDate($match->started_at) }} в {{ $match->started_at->format('H:i') }}
			</p>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				{{--
				<a href="#" class="card-icon"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 4</a>
				<a href="#" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> 50</a>
				--}}
			</div>
			<div class="event-date">
				<div class="text-uppercase">{{ $match->matchstatus->name }}</div>
				{{--<div class="date">12.02.2019 в 19:00</div>--}}
			</div>
		</div>
	</div>

	<div class="card-wrap">
		<h2 class="title">Коэффициенты</h2>

		<div class="bets-box">
			<div class="nav nav-tabs outcometype-tabs">
				<a class="nav-item nav-link active" id="outcometype-1-tab" data-toggle="tab" href="#outcometype-1" aria-controls="outcometype-1" aria-selected="true">1Х2</a>
				<a class="nav-item nav-link" id="outcometype-2-tab" data-toggle="tab" href="#outcometype-2" aria-controls="outcometype-2" aria-selected="false">1 или 2</a>
				{{--
				<a class="nav-item nav-link" id="outcometype-3-tab" data-toggle="tab" href="#outcometype-3" aria-controls="outcometype-3" aria-selected="false">Б/М</a>
				<a class="nav-item nav-link" id="outcometype-4-tab" data-toggle="tab" href="#outcometype-4" aria-controls="outcometype-4" aria-selected="false">АГ</a>
				<a class="nav-item nav-link" id="outcometype-5-tab" data-toggle="tab" href="#outcometype-5" aria-controls="outcometype-5" aria-selected="false">ЕГ</a>
				--}}
				<a class="nav-item nav-link" id="outcometype-6-tab" data-toggle="tab" href="#outcometype-6" aria-controls="outcometype-6" aria-selected="false">Двойной шанс</a>
				{{--
				<a class="nav-item nav-link" id="outcometype-7-tab" data-toggle="tab" href="#outcometype-7" aria-controls="outcometype-7" aria-selected="false">HT/FT</a>
				<a class="nav-item nav-link" id="outcometype-8-tab" data-toggle="tab" href="#outcometype-8" aria-controls="outcometype-8" aria-selected="false">ТС</a>
				--}}
				<a class="nav-item nav-link" id="outcometype-9-tab" data-toggle="tab" href="#outcometype-9" aria-controls="outcometype-9" aria-selected="false">Чет/Нечет</a>
				<a class="nav-item nav-link" id="outcometype-10-tab" data-toggle="tab" href="#outcometype-10" aria-controls="outcometype-10" aria-selected="false">Обе забьют?</a>
			</div>
			<div class="tab-content outcometype-content">
				<div class="tab-pane fade show active" id="outcometype-1" aria-labelledby="outcometype-1-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-1-1-tab" data-toggle="tab" href="#outcomescope-1-1" aria-controls="outcomescope-1-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-1-2-tab" data-toggle="tab" href="#outcomescope-1-2" aria-controls="outcomescope-1-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-1-3-tab" data-toggle="tab" href="#outcomescope-1-3" aria-controls="outcomescope-1-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-1-1" aria-labelledby="outcomescope-1-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-1-2" aria-labelledby="outcomescope-1-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-1-3" aria-labelledby="outcomescope-1-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-2" aria-labelledby="outcometype-2-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-2-1-tab" data-toggle="tab" href="#outcomescope-2-1" aria-controls="outcomescope-2-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-2-2-tab" data-toggle="tab" href="#outcomescope-2-2" aria-controls="outcomescope-2-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-2-3-tab" data-toggle="tab" href="#outcomescope-2-3" aria-controls="outcomescope-2-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-2-1" aria-labelledby="outcomescope-2-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-2-2" aria-labelledby="outcomescope-2-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-2-3" aria-labelledby="outcomescope-2-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-6" aria-labelledby="outcometype-6-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-6-1-tab" data-toggle="tab" href="#outcomescope-6-1" aria-controls="outcomescope-6-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-6-2-tab" data-toggle="tab" href="#outcomescope-6-2" aria-controls="outcomescope-6-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-6-3-tab" data-toggle="tab" href="#outcomescope-6-3" aria-controls="outcomescope-6-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-6-1" aria-labelledby="outcomescope-6-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-6-2" aria-labelledby="outcomescope-6-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-6-3" aria-labelledby="outcomescope-6-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-9" aria-labelledby="outcometype-9-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-9-1-tab" data-toggle="tab" href="#outcomescope-9-1" aria-controls="outcomescope-9-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-9-2-tab" data-toggle="tab" href="#outcomescope-9-2" aria-controls="outcomescope-9-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-9-3-tab" data-toggle="tab" href="#outcomescope-9-3" aria-controls="outcomescope-9-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-9-1" aria-labelledby="outcomescope-9-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-9-2" aria-labelledby="outcomescope-9-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-9-3" aria-labelledby="outcomescope-9-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="outcometype-10" aria-labelledby="outcometype-10-tab">
					<div class="nav nav-tabs outcomescope-tabs">
						<a class="nav-item nav-link active" id="outcomescope-10-1-tab" data-toggle="tab" href="#outcomescope-10-1" aria-controls="outcomescope-10-1" aria-selected="true">Осн. время</a>
						<a class="nav-item nav-link" id="outcomescope-10-2-tab" data-toggle="tab" href="#outcomescope-10-2" aria-controls="outcomescope-10-2" aria-selected="false">1-й тайм</a>
						<a class="nav-item nav-link" id="outcomescope-10-3-tab" data-toggle="tab" href="#outcomescope-10-3" aria-controls="outcomescope-10-3" aria-selected="false">2-й тайм</a>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="outcomescope-10-1" aria-labelledby="outcomescope-10-1-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-10-2" aria-labelledby="outcomescope-10-2-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
						<div class="tab-pane fade" id="outcomescope-10-3" aria-labelledby="outcomescope-10-3-tab">
							<p class="text-center pb-3 pt-3">Загрузка...</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})

		$(document).ready(function () {
			ssOffers().setUrl('{{ route('site.match.show', ['match' => $match->id]) }}');

			$("*[id^='outcomescope-']").bind('ss.offers.loaded', function (e, self, content) {
				if (/outcomescope\-[0-9]+\-[0-9]+$/.test($(this).attr('id'))) {
					// группируем контент
					content = $('<div>' + content + '<div>').find('#nav');

					/**
					 * подсвечиваем коэффициенты
					 *
					 */

					(function () {
						var o;
						var types = content.find('.bets-table tr').eq(0).find('.outcomesubtype').length;

						for (var i = 0; i < types; i++) {
							o = null;
							content.find('.bets-table tr').each(function () {
								if ($(this).find('.odds').length == 0)
									return;

								if ($(this).find('.odds span').length == 0)
									return;

								if (
										null === o
									||	parseFloat($(this).find('.odds').eq(i).find('span').text()) > parseFloat(o.find('span').text())
								)
									o = $(this).find('.odds').eq(i);
							});

							if (null !== o)
								o.addClass('odds-max');
						}
					})();

					// подгружаем контент
					$(this).html('<div data-ss-offers-content>' + content.html() + '<div>');
				}
			});

			// авто подгрузка при открытие страницы
			ssOffers('1x2', 'ord').load('#outcomescope-1-1');

			// подгрузка при клике 1х2 первый тайм
			$('#outcomescope-1-2-tab').bind('shown.bs.tab', function () {
				ssOffers('1x2', '1h').load('#outcomescope-1-2');
			});

			// подгрузка при клике 1х2 второй тайм
			$('#outcomescope-1-3-tab').bind('shown.bs.tab', function () {
				ssOffers('1x2', '2h').load('#outcomescope-1-3');
			});

			// подгрузка при клике на таб 1 или 2 (автоматом подгружаем основное время)
			$('#outcometype-2-tab').bind('shown.bs.tab', function () {
				ssOffers('12', 'ord').load('#outcomescope-2-1');
			});

			// подгрузка при клике 1 или 2 первый тайм
			$('#outcomescope-2-2-tab').bind('shown.bs.tab', function () {
				ssOffers('12', '1h').load('#outcomescope-2-2');
			});

			// подгрузка при клике 1 или 2 второй тайм
			$('#outcomescope-2-3-tab').bind('shown.bs.tab', function () {
				ssOffers('12', '2h').load('#outcomescope-2-3');
			});

			// подгрузка при клике на таб ди (автоматом подгружаем основное время)
			$('#outcometype-6-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', 'ord').load('#outcomescope-6-1');
			});

			// подгрузка при клике ди первый тайм
			$('#outcomescope-6-2-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', '1h').load('#outcomescope-6-2');
			});

			// подгрузка при клике ди второй тайм
			$('#outcomescope-6-3-tab').bind('shown.bs.tab', function () {
				ssOffers('dc', '2h').load('#outcomescope-6-3');
			});

			// подгрузка при клике на таб чн (автоматом подгружаем основное время)
			$('#outcometype-9-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', 'ord').load('#outcomescope-9-1');
			});

			// подгрузка при клике чн первый тайм
			$('#outcomescope-9-2-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', '1h').load('#outcomescope-9-2');
			});

			// подгрузка при клике чн второй тайм
			$('#outcomescope-9-3-tab').bind('shown.bs.tab', function () {
				ssOffers('oe', '2h').load('#outcomescope-9-3');
			});

			// подгрузка при клике на таб оз (автоматом подгружаем основное время)
			$('#outcometype-10-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', 'ord').load('#outcomescope-10-1');
			});

			// подгрузка при клике оз первый тайм
			$('#outcomescope-10-2-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', '1h').load('#outcomescope-10-2');
			});

			// подгрузка при клике оз второй тайм
			$('#outcomescope-10-3-tab').bind('shown.bs.tab', function () {
				ssOffers('bts', '2h').load('#outcomescope-10-3');
			});
		});
	</script>

	@if ($forecasts->count())
		<div class="card-wrap" id="forecasts">
			<h2 class="title">Прогнозы на матч</h2>

			@foreach ($forecasts as $forecast)
				<div class="cards_list d-none d-md-block">
					@include('card.site.forecast.normal', [
						'forecast' => $forecast
					])
				</div>
			@endforeach

			<!-- для мобилы -->
			@foreach ($forecasts as $forecast)
				<div class="cards_tile d-block d-md-none">
					@include('card.site.forecast.normal', [
						'forecast' => $forecast
					])
				</div>
			@endforeach
			<!-- end для мобилы -->
		</div>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.match')
@endsection


