<div data-ss-filter-url="{{ route('site.deal.filter') }}" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
	  role="button"
	  data-toggle="collapse"
	  data-target="#filter"
	  aria-expanded="false"
	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> Фильтр</div>
	<div class="collapse" id="filter" data-parent="#filter-box">
		@if (!is_null(Dealparameter::topical('type')))
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type"><span class="dashed">Тип бонуса</span></h5>
				<div class="collapse show" id="type" data-parent="#filter">
					<div id="param-type">
						@foreach (Dealparameter::topical('type')->getParameters()['values'] as $key => $value)
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="type"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									{!! $value['current'] ? 'checked="checked"' : '' !!}
									id="type{{ $key }}"
									value="{{ $value['value'] }}"
								>
								<label class="custom-control-label" for="type{{ $key }}">
									<div><span class="dashed">{{ $value['name'] }}</span></div>
								</label>
							</a>
						@endforeach

						@if (Dealparameter::get('type', false))
							<input type="hidden" data-ss-pn-parameter="type" value="{{ Dealparameter::get('type') }}">
						@endif
					</div>
				</div>
			</div>
		@endif

		@if (!is_null(Dealparameter::topical('bookmaker')))
			<div id="filter-options-bookmaker" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#bookmaker" aria-expanded="true" aria-controls="bookmaker"><span class="dashed">Букмекер</span></h5>
				<div class="collapse show" id="bookmaker" data-parent="#filter-options-bookmaker">
					<div id="param-bookmaker" class="filter-options-body">
						<select
							data-ss-filter-select="bookmaker"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Букмекер</option>
							@foreach (Dealparameter::topical('bookmaker')->getParameters()['values'] as $value)
								<option
									{!! $value['current'] ? 'selected="selected"' : '' !!}
									value="{{ $value['value'] }}"
								>
									{{ $value['name'] }}
								</option>
							@endforeach

						</select>

						@if (Dealparameter::get('bookmaker', false))
							<input type="hidden" data-ss-pn-parameter="bookmaker" value="{{ Dealparameter::get('bookmaker') }}">
						@endif
					</div>
				</div>
			</div>
		@endif
	</div>
</div>