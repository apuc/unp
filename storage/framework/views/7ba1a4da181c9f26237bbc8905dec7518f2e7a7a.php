<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.event.index'),
		'dataset'   => $event,
		'model'     => \App\Event::class,
		'groups'	=> [
			'properties' => [
				'happened_at',
				'action',
				'user',
				'visitor',
				'params',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/event/create.blade.php ENDPATH**/ ?>