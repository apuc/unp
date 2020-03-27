<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.bannerimpression.index'),
		'dataset'   => $bannerimpression,
		'model'     => \App\Bannerimpression::class,
		'groups'	=> [
			'properties' => [
				'bannerpost',
				'user',
				'impressed_at',
				'ip',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bannerimpression/create.blade.php ENDPATH**/ ?>