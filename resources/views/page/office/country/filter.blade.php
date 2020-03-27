<div class="country-filter filter-box hidden">
	<form class="form-horizontal" method="get">
		<div class="row">
			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'name',
					'value'		=> $name,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'slug',
					'value'		=> $slug,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'external_id',
					'value'		=> $external_id,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'external_name',
					'value'		=> $external_name,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-boolean', [
					'field'		=> 'is_enabled',
					'value'		=> $is_enabled,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 ml-lg-auto col-lg-6">
				<div class="form-group row">
					<div class="ml-sm-auto col-sm-8">
							<button type="submit" class="btn btn-primary" title="@lang('button.office.filtered')"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.filtered')</span></button>
							&nbsp;
							<button onclick="location.assign('{{ route('office.country.index') }}');" type="button" class="btn btn-primary" title="@lang('button.office.reset')">
								<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.reset')</span>
							</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.country-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		// если радио кнопка is_enabled
		if ($(this).attr('name') == 'f_is_enabled') {
			if ($(this).prop('checked') == false)
				return;

			if ($(this).val() == '')
				return;
		}

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.country-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script>