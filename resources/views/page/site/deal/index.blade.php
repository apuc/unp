@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap mt-3">

		@include('partial.site.panel.deal.sort')

		<div data-ss-pn-content id="view-cards-box">
			@if ($deals['rows']->count())
				<div class="cards-box {{ $deals['view'] == 0 ? 'cards_tile' : 'cards_list'}}">
					<div class="row">
						@foreach ($deals['rows'] as $deal)
							<div class="col-12 col-md-6 col-lg-4">
								@include('card.site.deal.normal', [
									'deal' => $deal,
								])
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<div {!! (!$deals['rows']->hasMorePages()) ? 'style="display: none"' : '' !!} class="btn-more-box">
				<input
					data-ss-pn-parameter="page"
					type="hidden"
					value="{{ $deals['rows']->currentPage() }}"
				>
				<a
					data-ss-pn-submit="click"
					data-ss-pn-page-value="{{ $deals['rows']->currentPage() + 1 }}"
					href="javascript: void(0);"
					class="btn btn-more"
				>Ещё акции</a>
			</div>
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
	@if (filled($document = Text::get($sitesection, 'top')))
		<section class="text-top">
			{!! $document->content !!}
		</section>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.deals')
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
		<section class="text-bottom">
			{!! $document->content !!}
		</section>
	@endif
@endsection

