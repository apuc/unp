<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.country.show', $country->id),
		'dataset'   => $country,
		'model'     => \App\Country::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'flag',
				'is_enabled',
			],
			'external' => [
				'external_id',
				'external_name',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/country/edit.blade.php ENDPATH**/ ?>