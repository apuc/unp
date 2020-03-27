@extends('layout.site.grid.double')

@section('content')
	<!-- Таблица матчей -->
	<div class="mb-5">

		@include('partial.site.panel.match.filter')

		<div data-ss-pn-content data-ss-pn-return-datatype="json" data-ss-pn-url="{{ route('site.match.ajax') }}" id="view-cards-box">
			<div id="ss-vue-filter-load-list">
				<p class="mt-3 text-center">Загрузка...</p>
			</div>
		</div>

		<div id="ss-vue-filter-json" hidden>{!! collect([
			'dataset'		=> $dataset,
			'parameters'	=> [
				'days'			=> !is_null(Matchparameter::topical('day'))			? Matchparameter::topical('day')		->getParameters()['values']->toArray() : [],
				'sports'		=> !is_null(Matchparameter::topical('sport'))		? Matchparameter::topical('sport')		->getParameters()['values']->toArray() : [],
				'statuses'		=> !is_null(Matchparameter::topical('status'))		? Matchparameter::topical('status')		->getParameters()['values']->toArray() : [],
				'tournaments'	=> !is_null(Matchparameter::topical('tournament'))	? Matchparameter::topical('tournament')	->getParameters()['values']->toArray() : [],
			],
		])->toJson() !!}</div>

		<div id="ss-vue-filter-current-day" hidden>{{ Matchparameter::get('day', 'false') }}</div>
		<div id="ss-vue-filter-current-sport" hidden>{{ Matchparameter::get('sport', 'false') }}</div>
		<div id="ss-vue-filter-current-tournament" hidden>{{ Matchparameter::get('tournament', 'false') }}</div>
		<div id="ss-vue-filter-current-status" hidden>{{ Matchparameter::get('status', 'false') }}</div>

		<script>
			$(document).ready(function () {
				ssVueFilter({
					data:		$('#ss-vue-filter-json').text(),
					blocks:		['list', 'top', 'left'],
					components:	'{{ route('site.match.load') }}',
				}).load();

				/**
				 * перезагрузка контента
				 *
				 */

				ssPN().bind('ss.pn.content.update', function (e, data) {
					$('body').trigger('ss.pn.matches.update', [data]);
				});

				/**
				 *
				 *
				 */

				$('body').bind('ss.pn.submit-sport', function (e, box) {
					// удаляем выбранный турнир
					$("input[data-ss-pn-parameter='tournament']").remove();
					$('#param-tournament > a input').prop('checked', false);

					// удаляем статус
					$("input[data-ss-pn-parameter='status']").remove();
					$('#param-status select option').prop('selected', false);
				});

				/**
				 *
				 *
				 */

				$('body').bind('ss.pn.submit-day', function (e, box) {
					// удаляем выбранный турнир
					$("input[data-ss-pn-parameter='tournament']").remove();
					$('#param-tournament > a input').prop('checked', false);

					// удаляем спорт
					$("*[data-ss-pn-parameter='sport']").remove();

					// удаляем статус
					$("input[data-ss-pn-parameter='status']").remove();
					$('#param-status select option').prop('selected', false);
				});
			});
		</script>
	</div>
@endsection

@section('top')
	@if (filled($document = Text::get($sitesection, 'top')))
	   	<section class="text-top">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.matches')
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
	   	<section class="text-bottom">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection

