<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.briefpicture.show', $briefpicture->id),
		'dataset'   => $briefpicture,
		'model'     => \App\Briefpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'brief',
				'picture',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/briefpicture/edit.blade.php ENDPATH**/ ?>