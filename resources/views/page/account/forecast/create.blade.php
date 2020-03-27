@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap account-forecasts-detail">
		<h2 class="title">Прогноз</h2>
		<form data-ss-forecasts-form id="forecast-form" action="{{ route('account.forecast.store') }}" method="post" enctype="multipart/form-data" onsubmit="return false;">
			<input type="hidden" name="forecaststatus_id" value="">
			{{ csrf_field() }}

			<div data-ss-forecasts-sports></div>
			<div data-ss-forecasts-tournaments></div>
			<div data-ss-forecasts-matches></div>
			<div data-ss-forecasts-offers></div>

			<div data-ss-forecasts-rate hidden class="form-group row">
				<label class="col-md-3 col-form-label">Сумма ставки <span class="red">*</span></label>
				<div class="col-md-9">
					<div class="form-row">
						{{--
						<div class="col-6 col-md-4">
							<select class="form-control">
								<option>Фиксированная</option>
							</select>
						</div>
						--}}
						<div class="col-6 col-md-4">
							<select name="bet" class="form-control">
								<option value="">-- Выберите сумму ставки</option>
								<option value="50">50 Баллов</option>
								<option value="100">100 Баллов</option>
								<option value="250">250 Баллов</option>
								<option value="500">500 Баллов</option>
								<option value="1000">1000 Баллов</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div data-ss-forecasts-description hidden class="form-group">
				<label for="description">Описание</label>
				<div>
					{{--<img src="storage/profile/text-icons.png" class="img-fluid" alt="">--}}
					<textarea name="description" class="form-control" id="description" rows="10"></textarea>
				</div>
			</div>

			<div data-ss-forecasts-btn hidden class="mt-3 ml-4">
				<button type="submit" class="btn btn-primary btn-lg">Отправить</button>
			</div>
		</form>

		{{--
		<div class="pl-4 pt-4 text-sm">
			<p><b>Прогнозы без описания</b><br>
				Влияют на Ваш виртуальный банк, но на сайте в разделе "Прогнозы" не публикуются.</p>
			<p><b>Прогнозы с описанием</b><br>
				Прогнозы с описанием после проверки модератором на соответствие <a href="{{ route('site.legal.show', ['document' => 'rules']) }}">правилам сайта</a> публикуются на сайте.<br>
				Влияют на Ваш виртуальный банк.</p>
		</div>
		--}}
	</div>

	<script>
		$(document).ready(function () {
			var dataset = {};

			@if (null !== request()->sport_id)
				dataset['sport_id'] = '{{ request()->sport_id }}';
			@endif

			@if (null !== request()->tournament_id)
				dataset['tournament_id'] = '{{ request()->tournament_id }}';
			@endif

			@if (null !== request()->match_id)
				dataset['match_id'] = '{{ request()->match_id }}';
			@endif

			@if (null !== request()->type)
				dataset['type'] = '{{ request()->type }}';
			@endif

			@if (null !== request()->scope)
				dataset['scope'] = '{{ request()->scope }}';
			@endif

			ssForecasts('{{ route('account.forecast.sports') }}', dataset).load();

			$('#forecast-form').find("*[name='bet']").bind('change', function () {
				if ($(this).val() == '') {
					$("*[data-ss-forecasts-description]").attr('hidden', true);
					$("*[data-ss-forecasts-btn]").attr('hidden', true);
				}

				else {
					$("*[data-ss-forecasts-description]").removeAttr('hidden');
					$("*[data-ss-forecasts-btn]").removeAttr('hidden');
				}
			});

			$('#forecast-form').find('button').bind('click', function () {
				ssForecasts('{{ route('account.forecast.store') }}').save();
			});
		});
	</script>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection