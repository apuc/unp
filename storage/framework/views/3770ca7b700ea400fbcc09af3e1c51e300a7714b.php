<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.postpicture.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $postpicture)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.postpicture.edit', [
						'postpicture' => $postpicture->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $postpicture,
				'model'		=> \App\Postpicture::class,
				'groups'	=> [
					'properties' => [
						'name',
						'post',
						'picture',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/postpicture/show.blade.php ENDPATH**/ ?>