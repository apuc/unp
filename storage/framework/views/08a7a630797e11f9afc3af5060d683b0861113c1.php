<?php $__env->startSection('content'); ?>
	<div class="box">
		<div class="box-header">
			<div class="clearfix">
				<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', App\Brief::class)): ?>
					<?php echo $__env->make('control.office.toolbar.create', [
						'url' => route('office.brief.create'),
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>

				<?php echo $__env->make('control.office.toolbar.dataset', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<?php echo $__env->make('page.office.brief.filter-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>
		<?php echo $__env->make('page.office.brief.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->make('control.office.plate.index', [
			'dataset'	=> $briefs,
			'model'		=> \App\Brief::class,
			'fields'	=> [
				'posted_at',
				'briefstatus',
				'name',
				'sport',
				'user',
				'picture',
				'picture_author',
				'briefcomments_count',
				'briefpictures_count',
				'brieftags_count',
				'brieftournaments_count',
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

<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/brief/index.blade.php ENDPATH**/ ?>