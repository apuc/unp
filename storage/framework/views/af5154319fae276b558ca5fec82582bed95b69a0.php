<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.helppicture.show', $helppicture->id),
		'dataset'   => $helppicture,
		'model'     => \App\Helppicture::class,
		'groups'	=> [
			'properties' => [
				'helpquestion',
				'name',
				'picture',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/helppicture/edit.blade.php ENDPATH**/ ?>