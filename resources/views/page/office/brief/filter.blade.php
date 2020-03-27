<div class="brief-filter filter-box hidden">
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
				@include('control.office.filter.input-datetimerange', [
					'field'		=> 'posted_at',
					'value'		=> $posted_at,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'briefstatus',
					'id'		=> $briefstatus['id'],
					'value'		=> null !== $briefstatus['record'] ? $briefstatus['record']->name : null,
					'search'	=> route('office.briefstatus.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'sport',
					'id'		=> $sport['id'],
					'value'		=> null !== $sport['record'] ? $sport['record']->name : null,
					'search'	=> route('office.sport.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'user',
					'id'		=> $user['id'],
					'value'		=> null !== $user['record'] ? $user['record']->login : null,
					'search'	=> route('office.user.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 ml-lg-auto col-lg-6">
				<div class="form-group row">
					<div class="ml-sm-auto col-sm-8">
							<button type="submit" class="btn btn-primary" title="@lang('button.office.filtered')"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.filtered')</span></button>
							&nbsp;
							<button onclick="location.assign('{{ route('office.brief.index') }}');" type="button" class="btn btn-primary" title="@lang('button.office.reset')">
								<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.reset')</span>
							</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.brief-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.brief-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script>