<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.counter.show', $counter->id),
		'dataset'   => $counter,
		'model'     => \App\Counter::class,
		'groups'	=> [
			'properties' => [
				'name',
				'code_head',
				'code_top',
				'code_footer',
				'code_script',
				'is_enabled',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/counter/edit.blade.php ENDPATH**/ ?>