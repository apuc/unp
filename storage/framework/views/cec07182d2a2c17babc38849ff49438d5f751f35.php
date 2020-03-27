<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.bannerformat.show', $bannerformat->id),
		'dataset'   => $bannerformat,
		'model'     => \App\Bannerformat::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'width',
				'height',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bannerformat/edit.blade.php ENDPATH**/ ?>