<div class="team-filter filter-box hidden">
	<form class="form-horizontal" method="get">
		<div class="row">
			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'name',
					'value'		=> $name,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-search', [
					'field'		=> 'gender',
					'id'		=> $gender['id'],
					'value'		=> null !== $gender['record'] ? $gender['record']->name : null,
					'search'	=> route('office.gender.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-search', [
					'field'		=> 'sport',
					'id'		=> $sport['id'],
					'value'		=> null !== $sport['record'] ? $sport['record']->name : null,
					'search'	=> route('office.sport.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'external_id',
					'value'		=> $external_id,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-search', [
					'field'		=> 'country',
					'id'		=> $country['id'],
					'value'		=> null !== $country['record'] ? $country['record']->name : null,
					'search'	=> route('office.country.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 ml-lg-auto col-lg-6">
				<div class="form-group row">
					<div class="ml-sm-auto col-sm-8">
							<button type="submit" class="btn btn-primary" title="<?php echo app('translator')->get('button.office.filtered'); ?>"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;<span><?php echo app('translator')->get('button.office.filtered'); ?></span></button>
							&nbsp;
							<button onclick="location.assign('<?php echo e(route('office.team.index')); ?>');" type="button" class="btn btn-primary" title="<?php echo app('translator')->get('button.office.reset'); ?>">
								<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span><?php echo app('translator')->get('button.office.reset'); ?></span>
							</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.team-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.team-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/team/filter.blade.php ENDPATH**/ ?>