<?php $__env->startSection('content'); ?>
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\User::class)): ?>
					<?php echo $__env->make('control.office.toolbar.create', [
						'url' => route('office.user.create'),
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<?php echo $__env->make('control.office.toolbar.dataset', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<?php echo $__env->make('page.office.user.filter-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<?php echo $__env->make('page.office.user.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->make('control.office.plate.index', [
			'dataset'	=> $users,
			'model'		=> \App\User::class,
			'fields'	=> [
				'login',
				'name',
				'avatar',
				'role',
				'born_at',
				'email',
				'phone',
				'balance',
				'stat_roi',
				'stat_profit',
				'forecasts_count',
				'posts_count',
				'briefs_count',
				'visited_at',
			],
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>

	<?php echo $__env->make('partial.office.shell.modal-editor', [
		'action' => 'create'
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->make('partial.office.shell.modal-editor', [
    	'action' => 'edit'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/user/index.blade.php ENDPATH**/ ?>