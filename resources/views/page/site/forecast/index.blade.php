@extends('layout.site.grid.double')

@section('content')

	@include('partial.site.panel.forecast.filter')
	@include('partial.site.panel.forecast.sort')

	<div data-ss-pn-content>
		@if ($forecasts['rows']->count())
			<div class="cards-box {{ $forecasts['view'] == 0 ? 'cards_tile' : 'cards_list'}}">
				<div class="row">
					@foreach ($forecasts['rows'] as $forecast)
						<div class="col-12 col-md-4">
							@include('card.site.forecast.normal', [
								'forecast' => $forecast,
							])
						</div>
					@endforeach
				</div>
			</div>
		@endif

		<div {!! (!$forecasts['rows']->hasMorePages()) ? 'style="display: none"' : '' !!} class="btn-more-box">
			<input
				data-ss-pn-parameter="page"
				type="hidden"
				value="{{ $forecasts['rows']->currentPage() }}"
			>
			<a
				data-ss-pn-submit="click"
				data-ss-pn-page-value="{{ $forecasts['rows']->currentPage() + 1 }}"
				href="javascript: void(0);"
				class="btn btn-more"
			>Ещё прогнозы</a>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			ssPN().bind('ss.pn.content.update', function (e, data) {
				var page = $("*[data-ss-pn-parameter='page']").val();

				// обновляем контент
				data = $('<div>' + data + '</div>');

				// если первая страница
				if (page == 1) {
					// пересобираем блок целеком
					$("*[data-ss-pn-content]").html(
						data.find("*[data-ss-pn-content]").html()
					);
				}

				// если остальные
				else {
					// дополняем блоки
					$('.cards-box .row > div:last-child').after(
						data.find('.cards-box .row').html()
					);

					// заменяем кнопку
					if (data.find("*[data-ss-pn-content]").find('.btn-more-box').css('display') != 'none')
						$("*[data-ss-pn-content]").find('.btn-more-box').html(
							data.find("*[data-ss-pn-content]").find('.btn-more-box').html()
						);
					else
						$("*[data-ss-pn-content]").find('.btn-more-box').css('display', 'none');
				}
			});
		});
	</script>
@endsection

@section('top')
	<section class="text-top">
		<div class="row">
			<div class="text-top__btn">
				<a href="{{ route('account.forecast.create') }}" class="btn btn-primary btn-lg mb-3 mb-lg-0"><i class="fa fa-plus" aria-hidden="true"></i> Сделать прогноз</a>
			</div>
			<div class="col">
				{!! optional(Text::get($sitesection, 'top'))->content !!}
			</div>
		 </div>
	</section>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.forecasts')
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
	   	<section class="text-bottom">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection

