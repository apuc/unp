<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.sitepicture.show', $sitepicture->id),
		'dataset'   => $sitepicture,
		'model'     => \App\Sitepicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sitetext',
				'picture',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sitepicture/edit.blade.php ENDPATH**/ ?>