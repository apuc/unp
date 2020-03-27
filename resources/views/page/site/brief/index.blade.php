@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap mt-3">

		@include('partial.site.panel.brief.filter')
		@include('partial.site.panel.brief.sort')

		<div data-ss-pn-content id="view-cards-box">
			@if ($briefs['rows']->count())
				<div class="cards-box">
					@foreach ($briefs['rows'] as $brief)
						@include('card.site.brief.normal', [
							'brief' => $brief,
						])
					@endforeach
				</div>
			@endif

			<div {!! (!$briefs['rows']->hasMorePages()) ? 'style="display: none"' : '' !!} class="btn-more-box">
				<input
					data-ss-pn-parameter="page"
					type="hidden"
					value="{{ $briefs['rows']->currentPage() }}"
				>
				<a
					data-ss-pn-submit="click"
					data-ss-pn-page-value="{{ $briefs['rows']->currentPage() + 1 }}"
					href="javascript: void(0);"
					class="btn btn-more"
				>Ещё новости</a>
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
				if (page == 1)
					// пересобираем блок целеком
					$("*[data-ss-pn-content]").html(
						data.find("*[data-ss-pn-content]").html()
					);

				// если остальные
				else {
					// дополняем блоки
					$('.cards-box > div:last-child').after(
						data.find('.cards-box').html()
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
			{{--
			<div class="text-top__btn">
				<a href="{{ route('account.brief.create') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> опубликовать новость</a>
			</div>
			--}}
			<div class="col">
				{!! optional(Text::get($sitesection, 'top'))->content !!}
			</div>
		 </div>
	</section>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.briefs')
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
	   	<section class="text-bottom">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection
