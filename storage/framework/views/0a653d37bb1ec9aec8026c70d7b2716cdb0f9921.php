<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.commentstatus.index'),
		'dataset'   => $commentstatus,
		'model'     => \App\Commentstatus::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'color_bg',
				'color_fg',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/commentstatus/create.blade.php ENDPATH**/ ?>