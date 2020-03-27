<div data-ss-filter-url="{{ route('account.forecast.filter') }}" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
		role="button"
		data-toggle="collapse"
		data-target="#filter"
		aria-expanded="false"
		aria-controls="filter"
	>
		<i class="fa fa-sliders" aria-hidden="true"></i> МОИ ЛИГИ
	</div>

	<div class="collapse" id="filter" data-parent="#filter-box">

		@if (!is_null(Forecastparameter::topical('tournament')))
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#tournament" aria-expanded="true" aria-controls="tournament"><span class="dashed">Турниры</span></h5>
				<div class="collapse show" id="tournament" data-parent="#filter">
					<div id="param-tournament">
						@foreach (
							Forecastparameter::topical('tournament')->getParameters()['values']->filter(function ($param) {
								return !is_null($param['position']);
							})->sortBy(function ($param, $key) {
								return $param['position'];
							}) as $key => $value
						)
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="tournament"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									{!! $value['current'] ? 'checked="checked"' : '' !!}
									id="tournament{{ $key }}"
									value="{{ $value['value'] }}"
								>
								<label class="custom-control-label" for="tournament{{ $key }}">
									<div><span class="dashed">{{ $value['name'] }}</span></div>
								</label>
							</a>
						@endforeach

						@foreach (
							Forecastparameter::topical('tournament')->getParameters()['values']->filter(function ($param) {
								return is_null($param['position']);
							}) as $key => $value
						)
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="tournament"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									{!! $value['current'] ? 'checked="checked"' : '' !!}
									id="tournament{{ $key }}"
									value="{{ $value['value'] }}"
								>
								<label class="custom-control-label" for="tournament{{ $key }}">
									<div><span class="dashed">{{ $value['name'] }}</span></div>
								</label>
							</a>
						@endforeach

						@if (Forecastparameter::get('tournament', false))
							<input type="hidden" data-ss-pn-parameter="tournament" value="{{ Forecastparameter::get('tournament') }}">
						@endif
					</div>
				</div>
			</div>
		@endif

		@if (!is_null(Forecastparameter::topical('status')))
			<div id="filter-options-status" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status"><span class="dashed">Статус</span></h5>
				<div class="collapse show" id="status" data-parent="#filter-options-status">
					<div id="param-status" class="filter-options-body">
						<select
							data-ss-filter-select="status"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Статус</option>
							@foreach (Forecastparameter::topical('status')->getParameters()['values'] as $value)
								<option
									{!! $value['current'] ? 'selected="selected"' : '' !!}
									value="{{ $value['value'] }}"
								>
									{{ $value['name'] }}
								</option>
							@endforeach

						</select>

						@if (Forecastparameter::get('status', false))
							<input type="hidden" data-ss-pn-parameter="status" value="{{ Forecastparameter::get('status') }}">
						@endif
					</div>
				</div>
			</div>
		@endif

		<div class="filter-btns">
			{{--<button data-ss-filter-button data-ss-pn-button="match-filter" data-ss-pn-submit="click" class="btn btn-primary">Показать</button>--}}
			<a href="{{ route('account.forecast.index') }}" class="btn btn-light">Сбросить фильтр</a>
		</div>
	</div>
</div>
