@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap mt-3">

		@include('partial.site.panel.bookmaker.sort')

		<div data-ss-pn-content id="view-cards-box">
			@if ($bookmakers['rows']->count())
				<div class="cards-box {{ $bookmakers['view'] == 0 ? 'cards_tile' : 'cards_list'}}">
					<div class="row">
						@foreach ($bookmakers['rows'] as $bookmaker)
							<div class="col-12 col-md-4">
								@include('card.site.bookmaker.normal', [
									'boomaker' => $bookmaker,
								])
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<div {!! (!$bookmakers['rows']->hasMorePages()) ? 'style="display: none"' : '' !!} class="btn-more-box">
				<input
					data-ss-pn-parameter="page"
					type="hidden"
					value="{{ $bookmakers['rows']->currentPage() }}"
				>
				<a
					data-ss-pn-submit="click"
					data-ss-pn-page-value="{{ $bookmakers['rows']->currentPage() + 1 }}"
					href="javascript: void(0);"
					class="btn btn-more"
				>Ещё букмекеры</a>
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
	<section class="text-top">
		<div class="row">
			<div class="col-12 col-lg-9 mb-3 mb-lg-0">
				{!! optional(Text::get($sitesection, 'top'))->content !!}
			</div>
		 </div>
	</section>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.bookmakers')
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
		<section class="text-bottom">
			{!! $document->content !!}
		</section>
	@endif
@endsection

