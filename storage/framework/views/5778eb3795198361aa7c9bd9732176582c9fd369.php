<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.bannerpost.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $bannerpost)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.bannerpost.edit', [
						'bannerpost' => $bannerpost->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $bannerpost,
				'model'		=> \App\Bannerpost::class,
				'groups'	=> [
					'properties' => [
						'banner',
						'sitesection',
						'bannerplace',
						'margin',
						'started_at',
						'finished_at',
						'view_limit',
						'view_amount',
						'click_limit',
						'click_amount',
						'is_enabled',
						'is_debug',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bannerpost/show.blade.php ENDPATH**/ ?>