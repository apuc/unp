<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.briefcomment.index'),
		'dataset'   => $briefcomment,
		'model'     => \App\Briefcomment::class,
		'groups'	=> [
			'properties' => [
				'brief',
				'user',
				'commentstatus',
				'posted_at',
				'message',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/briefcomment/create.blade.php ENDPATH**/ ?>