<div data-ss-filter-url="{{ route('site.brief.filter') }}" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
	  role="button"
	  data-toggle="collapse"
	  data-target="#filter"
	  aria-expanded="false"
	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> МОИ ЛИГИ</div>
	<div class="collapse" id="filter" data-parent="#filter-box">

		@if (!is_null(Briefparameter::topical('tournament')))
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#tournament" aria-expanded="true" aria-controls="tournament"><span class="dashed">Турниры</span></h5>
				<div class="collapse show" id="tournament" data-parent="#filter">
					<div id="param-tournament">
						@foreach (Briefparameter::topical('tournament')->getParameters()['values'] as $key => $value)
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

						@if (Briefparameter::get('tournament', false))
							<input type="hidden" data-ss-pn-parameter="tournament" value="{{ Briefparameter::get('tournament') }}">
						@endif
					</div>
				</div>
			</div>
		@endif

		@if (!is_null(Briefparameter::topical('country')))
			<div id="filter-options-country" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#country" aria-expanded="true" aria-controls="country"><span class="dashed">Страна</span></h5>
				<div class="collapse show" id="country" data-parent="#filter-options-country">
					<div id="param-country" class="filter-options-body">
						<select
							data-ss-filter-select="country"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Страна</option>
							@foreach (Briefparameter::topical('country')->getParameters()['values'] as $value)
								<option
									{!! $value['current'] ? 'selected="selected"' : '' !!}
									value="{{ $value['value'] }}"
								>
									{{ $value['name'] }}
								</option>
							@endforeach

						</select>

						@if (Briefparameter::get('country', false))
							<input type="hidden" data-ss-pn-parameter="country" value="{{ Briefparameter::get('country') }}">
						@endif
					</div>
				</div>
			</div>
		@endif

		<div class="filter-btns">
			{{--<button data-ss-filter-button data-ss-pn-button="brief-filter" data-ss-pn-submit="click" class="btn btn-primary">Показать</button>--}}
			<a href="{{ route('site.brief.index') }}" class="btn btn-light">Сбросить фильтр</a>
		</div>
	</div>
</div>