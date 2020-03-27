<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.stage.show', $stage->id),
		'dataset'   => $stage,
		'model'     => \App\Stage::class,
		'groups'	=> [
			'properties' => [
				'name',
				'season',
				'gender',
				'country',
				'external_id',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/stage/edit.blade.php ENDPATH**/ ?>