<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.forecastpicture.show', $forecastpicture->id),
		'dataset'   => $forecastpicture,
		'model'     => \App\Forecastpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'forecast',
				'picture',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/forecastpicture/edit.blade.php ENDPATH**/ ?>