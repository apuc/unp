<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.stage.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $stage)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.stage.edit', [
						'stage' => $stage->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $stage,
				'model'		=> \App\Stage::class,
				'groups'	=> [
					'properties' => [
						'name',
						'tournament',
						'season',
						'gender',
						'country',
						'external_id',
					],
					'statistics' => [
						'matches_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Match::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $matches,
				'model'		=> \App\Match::class,
				'fields'	=> [
					'name',
					'started_at',
					'matchstatus',

					'bookmaker1',
					'odds1_current',
					'odds1_old',

					'bookmakerx',
					'oddsx_current',
					'oddsx_old',

					'bookmaker2',
					'odds2_current',
					'odds2_old',

					'external_id',

					'participants_count',
					'forecasts_count',
				],
				'values'	=> [
					'stage_id' => $stage->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/stage/show.blade.php ENDPATH**/ ?>