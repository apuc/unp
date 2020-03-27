<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.outcometype.index'),
		'dataset'   => $outcometype,
		'model'     => \App\Outcometype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'description',
				'position',
				'is_enabled',
			],
			'external' => [
				'external_id',
				'external_name',
				'external_description',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/outcometype/create.blade.php ENDPATH**/ ?>