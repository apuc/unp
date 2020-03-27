<div data-ss-forecasts-sports class="form-group row">
	<label for="sport" class="col-md-3 col-form-label">Спорт <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'{{ route('account.forecast.tournaments') }}',
				{
					'sport_id': $('#sport').val()
				}
			).load();
		" name="sport_id" class="form-control" id="sport">
			<option value="">-- Выберите спорт</option>
			@foreach ($sports as $sport)
				<option {!! $sport_id == $sport['id'] ? 'selected="selected"' : '' !!} value="{{ $sport['id'] }}">{{ $sport['name'] }}</option>
			@endforeach
		</select>
	</div>
</div>