<div class="b-filter-top">
	<div class="b-filter-top__sport-nav">
		<ul class="b-filter-top__sport-main-list">
			<li class="b-filter-top__sport-main-item">
				<a
					href="javascript: void(0);"
					data-ss-pn-submit="click"
					data-ss-pn-sport-value=""
					class="nav-link {!! false === Forecastparameter::get('sport', false) ? 'active' : '' !!}"
				>Все</a>
			</li>
			@if (!is_null(Forecastparameter::topical('sport')))
				@if (Forecastparameter::get('sport', false))
					<input
						data-ss-pn-parameter="sport"
						type="hidden"
						value="{{ Forecastparameter::get('sport') }}"
					>
				@endif

				@foreach (Forecastparameter::topical('sport')->getParameters()['values']->slice(0, 3) as $value)
					<li class="b-filter-top__sport-main-item">
						<a
							href="javascript: void(0);"
							data-ss-pn-submit="click"
							data-ss-pn-sport-value="{{ $value['value'] }}"
							class="nav-link {!! $value['current'] ? 'active' : '' !!}"
						>{{ $value['name'] }}</a>
					</li>
				@endforeach

				@if (Forecastparameter::topical('sport')->getParameters()['values']->count() > 3)
					<li class="b-filter-top__sport-main-item b-filter-top__sport-other-button">
						<a class="
							nav-link
							dropdown-toggle

							@if(Forecastparameter::topical('sport')->getParameters()['values']->slice(3)->filter(function ($value) {
								return $value['current'];
							})->count())
								active
							@endif
						" href="#">Прочие</a>

						<div class="win-nav b-filter-top__sport-other-pulldown">
							<div class="win-cont">
								<ul>
									@foreach (Forecastparameter::topical('sport')->getParameters()['values']->slice(3) as $value)
										<li class="nav-item">
											<a
												href="javascript: void(0);"
												data-ss-pn-submit="click"
												data-ss-pn-sport-value="{{ $value['value'] }}"
												class="{!! $value['current'] ? 'active' : '' !!}"
											>{{ $value['name'] }}</a>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</li>
				@endif
			@endif
		</ul>

		@if (!is_null(Forecastparameter::topical('day')))
			@if (Forecastparameter::get('day', false))
				<input
					data-ss-pn-parameter="day"
					data-ss-filter-input="day"
					type="hidden"
					value="{{ Forecastparameter::get('day') }}"
				>
			@endif

			<div class="b-filter-top__calendar b-calendar">
				<div class="b-calendar__nav">
					<div class="b-calendar__nav-prev" title="Предыдущий день"></div>
				</div>
				<div class="b-calendar__date-picker">
					<div class="b-calendar__button" id="calendar-dates" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="b-calendar__icon"></span> <span>{{
							call_user_func(function () {
								$day = Forecastparameter::get('day', now()->format('Y-m-d'));
								return ''
									. now()->parse($day)->format('d/m ')
									. trans('days.abb.' . now()->parse($day)->format('w'))
								;
							})
						}}</span>
					</div>
					<div class="b-calendar-dates dropdown-menu" aria-labelledby="calendar-dates">
						@foreach (Forecastparameter::topical('day')->getParameters()['values'] as $value)
							<div
								data-ss-pn-submit="click"
								data-ss-pn-day-value="{{ $value['value'] }}"
								class="day {!! $value['current'] ? 'active' : '' !!}"
							>{{ $value['name_format'] }}<span hidden>{{ $value['name'] }}</span></div>
						@endforeach
					</div>
				</div>
				<div class="b-calendar__nav">
					<div class="b-calendar__nav-next" title="Следующий день"></div>
				</div>
			</div>
		@endif
	</div>
</div>