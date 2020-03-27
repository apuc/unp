<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.participant.show', $participant->id),
		'dataset'   => $participant,
		'model'     => \App\Participant::class,
		'groups'	=> [
			'properties' => [
				'match',
				'team',
				'score',
				'position',
				'external_id',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/participant/edit.blade.php ENDPATH**/ ?>