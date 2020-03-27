<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.forecast.show', $forecast->id),
		'dataset'   => $forecast,
		'model'     => \App\Forecast::class,
		'groups'	=> [
			'properties' => [
				'sport',
				'outcome',
				'bookmaker',
				'match',
				'user',
				'forecaststatus',
				'rate',
				'bet',
				'posted_at',
				'description',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/forecast/edit.blade.php ENDPATH**/ ?>