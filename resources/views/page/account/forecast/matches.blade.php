<div data-ss-forecasts-matches class="form-group row">
	<label for="match" class="col-md-3 col-form-label">Матч <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'{{ route('account.forecast.offers') }}',
				{
					'match_id': $('#match').val()
				}
			).load();
		" name="match_id" class="form-control" id="match">
			<option value="">-- Выберите матч</option>
			@foreach ($matches as $match)
				<option {!! $match_id == $match['id'] ? 'selected="selected"' : '' !!} value="{{ $match['id'] }}">{{ $match['team1_name'] }} &ndash; {{ $match['team2_name'] }}</option>
			@endforeach
		</select>
	</div>
</div>