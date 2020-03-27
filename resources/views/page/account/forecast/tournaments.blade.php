<div data-ss-forecasts-tournaments class="form-group row">
	<label for="tournament" class="col-md-3 col-form-label">Чемпионат <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'{{ route('account.forecast.matches') }}',
				{
					'tournament_id': $('#tournament').val(),
					'bookmaker_id': $('#bookmaker').val()
				}
			).load();
		" name="tournament_id" class="form-control" id="tournament">
			<option value="">-- Выберите турнир</option>
			@foreach ($tournaments as $tournament)
				<option {!! $tournament_id == $tournament['id'] ? 'selected="selected"' : '' !!} value="{{ $tournament['id'] }}">{{ $tournament['name'] }}</option>
			@endforeach
		</select>
	</div>
</div>