<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.posttournament.show', $posttournament->id),
		'dataset'   => $posttournament,
		'model'     => \App\Posttournament::class,
		'groups'	=> [
			'properties' => [
				'post',
				'tournament',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/posttournament/edit.blade.php ENDPATH**/ ?>