<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.benefit.index'),
		'dataset'   => $benefit,
		'model'     => \App\Benefit::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'icon',
				'announce',
				'url',
				'position',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/benefit/create.blade.php ENDPATH**/ ?>