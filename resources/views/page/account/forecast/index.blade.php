@extends('layout.site.grid.double')

@section('content')

	@include('partial.site.panel.forecast.filter')
	@include('partial.site.panel.forecast.sort')

	<div data-ss-pn-content>
		@if ($forecasts['rows']->count())
			<div class="cards-box {{ $forecasts['view'] == 0 ? 'cards_tile' : 'cards_list'}}">
				<div class="row">
					@foreach ($forecasts['rows'] as $forecast)
						<div class="col-12 col-md-6 col-xl-4">
							@include('card.site.forecast.normal', [
								'forecast' => $forecast,
							])
						</div>
					@endforeach
				</div>
			</div>
		@endif
	</div>
@endsection

@section('top')
	<section class="text-top">
		<div class="row">
			<div class="text-top__btn">
				<a href="{{ route('account.forecast.create') }}" class="btn btn-primary btn-lg mb-3 mb-lg-0"><i class="fa fa-plus" aria-hidden="true"></i> Сделать прогноз</a>
			</div>
			<div class="col">
				&nbsp;
			</div>
		</div>
	</section>
@endsection

@section('sidebar')
	@include('partial.account.sidebar.forecasts')
	@include('partial.site.sidebar.account')
@endsection