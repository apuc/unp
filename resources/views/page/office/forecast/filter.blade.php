<div class="forecast-filter filter-box hidden">
	<form class="form-horizontal" method="get">
		<div class="row">

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
				@include('control.office.filter.input-search', [
					'field'		=> 'match',
					'id'		=> $match['id'],
					'value'		=> null !== $match['record']
						? trans('option.office.match', [
							'name'			=> $match['record']->name,
							'started_at'	=> $match['record']->started_at->format('d.m.Y H:i'),
						])
						: null,
					'search'	=> route('office.match.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
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
				@include('control.office.filter.input-datetimerange', [
					'field'		=> 'started_at',
					'value'		=> $started_at,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'forecaststatus',
					'id'		=> $forecaststatus['id'],
					'value'		=> null !== $forecaststatus['record'] ? $forecaststatus['record']->name : null,
					'search'	=> route('office.forecaststatus.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'outcometype',
					'id'		=> $outcometype['id'],
					'value'		=> null !== $outcometype['record'] ? $outcometype['record']->name : null,
					'search'	=> route('office.outcometype.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'user',
					'id'		=> $user['id'],
					'value'		=> null !== $user['record'] ? $user['record']->name : null,
					'search'	=> route('office.user.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'outcomesubtype',
					'id'		=> $outcomesubtype['id'],
					'value'		=> null !== $outcomesubtype['record'] ? $outcomesubtype['record']->name : null,
					'search'	=> route('office.outcomesubtype.search'),
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
					'field'		=> 'outcomescope',
					'id'		=> $outcomescope['id'],
					'value'		=> null !== $outcomescope['record'] ? $outcomescope['record']->name : null,
					'search'	=> route('office.outcomescope.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'tournament',
					'id'		=> $tournament['id'],
					'value'		=> null !== $tournament['record'] ? $tournament['record']->name : null,
					'search'	=> route('office.tournament.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'bookmaker',
					'id'		=> $bookmaker['id'],
					'value'		=> null !== $bookmaker['record'] ? $bookmaker['record']->name : null,
					'search'	=> route('office.bookmaker.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'season',
					'id'		=> $season['id'],
					'value'		=> null !== $season['record'] ? $season['record']->name : null,
					'search'	=> route('office.season.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'rate',
					'value'		=> $rate,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-search', [
					'field'		=> 'stage',
					'id'		=> $stage['id'],
					'value'		=> null !== $stage['record'] ? $stage['record']->name : null,
					'search'	=> route('office.stage.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				])
			</div>

			<div class="col-xs-12 col-lg-6">
				@include('control.office.filter.input-text', [
					'field'		=> 'bet',
					'value'		=> $bet,
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
							<button onclick="location.assign('{{ route('office.forecast.index') }}');" type="button" class="btn btn-primary" title="@lang('button.office.reset')">
								<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span>@lang('button.office.reset')</span>
							</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.forecast-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.forecast-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script>