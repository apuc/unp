<div class="user-filter filter-box hidden">
	<form class="form-horizontal" method="get">
		<div class="row">

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'login',
					'value'		=> $f_login,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-date', [
					'field'		=> 'born_at',
					'value'		=> $f_born_at,
					'collabel'	=> 4,
					'colinput'	=> 7,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'name',
					'value'		=> $f_name,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'email',
					'value'		=> $f_email,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-search', [
					'field'		=> 'role',
					'id'		=> $f_role['id'],
					'value'		=> filled($f_role['record']) ? $f_role['record']->name : null,
					'search'	=> route('office.role.search'),
					'create'	=> null,
					'collabel'	=> 4,
					'colinput'	=> 7,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 col-lg-6">
				<?php echo $__env->make('control.office.filter.input-text', [
					'field'		=> 'phone',
					'value'		=> $f_phone,
					'collabel'	=> 4,
					'colinput'	=> 7,
					'readonly'	=> null,
					'mask'		=> '+7 (000) 000-00-00',
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<div class="col-xs-12 ml-lg-auto col-lg-6">
				<div class="form-group row">
					<div class="ml-sm-auto col-sm-8">
						<button type="submit" class="btn btn-primary" title="<?php echo app('translator')->get('button.office.filtered'); ?>"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;<span><?php echo app('translator')->get('button.office.filtered'); ?></span></button>
						&nbsp;
						<button onclick="location.assign('<?php echo e(route('office.user.index')); ?>');" type="button" class="btn btn-primary" title="<?php echo app('translator')->get('button.office.reset'); ?>">
							<i class="fa fa-times" aria-hidden="true"></i>&nbsp;<span><?php echo app('translator')->get('button.office.reset'); ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

	$('.user-filter').find("input").each(function (i) {
		if (undefined === $(this).attr('name'))
			return;

		if ($(this).val() != '') {
			$("span[data-ss-filter-toggle='.user-filter']").bind('ss-filter-toggle-inited', function () {
				$(this).trigger('click');
			});

			return false;
		}
	});

</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/user/filter.blade.php ENDPATH**/ ?>