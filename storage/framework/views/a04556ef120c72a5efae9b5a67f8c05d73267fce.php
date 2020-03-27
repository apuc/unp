<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.answer.show', $answer->id),
		'dataset'   => $answer,
		'model'     => \App\Answer::class,
		'groups'	=> [
			'properties' => [
				'issue',
				'posted_at',
				'user',
				'message',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/answer/edit.blade.php ENDPATH**/ ?>