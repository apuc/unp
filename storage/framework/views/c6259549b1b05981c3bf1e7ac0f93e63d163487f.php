<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.customparam.index'),
		'dataset'   => $customparam,
		'model'     => \App\Customparam::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'customgroup',
				'customtype',
				'value_string',
				'value_integer',
				'value_float',
				'value_text',
				'value_boolean',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/customparam/create.blade.php ENDPATH**/ ?>