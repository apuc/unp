<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.forecaststatus.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $forecaststatus)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.forecaststatus.edit', [
						'forecaststatus' => $forecaststatus->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $forecaststatus,
				'model'		=> \App\Forecaststatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'forecasts_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'bookmaker',
					'match',
					'started_at',
					'user',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'  	=> [
					'forecaststatus_id' => $forecaststatus->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/forecaststatus/show.blade.php ENDPATH**/ ?>