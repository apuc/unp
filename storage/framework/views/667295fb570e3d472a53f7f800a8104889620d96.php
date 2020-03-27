<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.legaledition.show', $legaledition->id),
		'dataset'   => $legaledition,
		'model'     => \App\Legaledition::class,
		'groups'	=> [
			'properties' => [
				'legaldocument',
				'issued_at',
				'content',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/legaledition/edit.blade.php ENDPATH**/ ?>