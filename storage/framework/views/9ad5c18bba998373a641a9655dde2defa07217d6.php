<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.outcome.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $outcome)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.outcome.edit', [
						'outcome' => $outcome->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $outcome,
				'model'		=> \App\Outcome::class,
				'groups'	=> [
					'properties' => [
						'tournament',
						'season',
						'stage',
						'match',
						'team',
						'outcometype',
						'outcomescope',
						'outcomesubtype',
					],
					'external' => [
						'external_id',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/outcome/show.blade.php ENDPATH**/ ?>