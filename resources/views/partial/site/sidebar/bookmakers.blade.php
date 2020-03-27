<div data-ss-filter-url="{{ route('site.deal.filter') }}" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
	  role="button"
	  data-toggle="collapse"
	  data-target="#filter"
	  aria-expanded="false"
	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> Фильтр</div>
	<div class="collapse" id="filter" data-parent="#filter-box">
		@if (!is_null(Bookmakerparameter::topical('type')))
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type"><span class="dashed">Предлагаемый бонус</span></h5>
				<div class="collapse show" id="type" data-parent="#filter">
					<div id="param-type">
						@foreach (Bookmakerparameter::topical('type')->getParameters()['values'] as $key => $value)
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

						@if (Bookmakerparameter::get('type', false))
							<input type="hidden" data-ss-pn-parameter="type" value="{{ Bookmakerparameter::get('type') }}">
						@endif
					</div>
				</div>
			</div>
		@endif
	</div>
</div>