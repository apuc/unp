<div class="tournament-filter filter-box hidden">
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
				@include('control.office.filter.input-search', [
					'field'		=> 'tournamenttype',
					'id'		=> $tournamenttype['id'],
					'value'		=> null !== $tournamenttype['record'] ? $tournamenttype['record']->name : null,
					'search'	=> route('office.tournamenttype.search'),
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
				@include('control.office.filter.input-text', [
					'field'		=> 'position',
					'value'		=> $position,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'gender',
					'id'		=> $gender['id'],
					'value'		=> null !== $gender['record'] ? $gender['record']->name : null,
					'search'	=> route('office.gender.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-boolean', [
					'field'		=> 'is_top',
					'value'		=> $is_top,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'id',
					'value'		=> $id,
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

			<div class="col-xs-12 ml-lg-auto col-lg-6">
				<div class="form-group row">
					<div class="ml-sm-auto col-sm-8">
							<button type="submit" class="btn btn-primary" title="@lang('button.office.filtered')"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.filtered')</span></button>
							&nbsp;
							<button onclick="location.assign('{{ route('office.tournament.index') }}');" type="button" class="btn btn-primary" title="@lang('button.office.reset')">
								<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.reset')</span>
							</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.tournament-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		// если радио кнопка is_top
		if ($(this).attr('name') == 'f_is_top') {
			if ($(this).prop('checked') == false)
				return;

			if ($(this).val() == '')
				return;
		}

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.tournament-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script>