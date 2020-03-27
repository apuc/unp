<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.helpquestion.index'),
		'dataset'   => $helpquestion,
		'model'     => \App\Helpquestion::class,
		'groups'	=> [
			'properties' => [
				'helpsection',
				'name',
				'answer',
				'is_enabled',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/helpquestion/create.blade.php ENDPATH**/ ?>