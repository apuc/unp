<?php $__env->startSection('content'); ?>
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Sport::class)): ?>
					<?php echo $__env->make('control.office.toolbar.create', [
						'url' => route('office.sport.create'),
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<?php echo $__env->make('control.office.toolbar.dataset', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<?php echo $__env->make('control.office.toolbar.filter-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<?php echo $__env->make('control.office.toolbar.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->make('control.office.plate.index', [
			'dataset'	=> $sports,
			'model'		=> \App\Sport::class,
			'fields'	=> [
				'name',
				'slug',
				'icon',
				'has_odds',
				'position',
				'external_id',
				'external_name',
				'tournamenttypes_count',
				'is_enabled',
				'teams_count',
				'tournamenttypes_count',
				'tournaments_count',
				'posts_count',
				'briefs_count',
				'forecasts_count',
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

<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sport/index.blade.php ENDPATH**/ ?>