<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.outcome.show', $outcome->id),
		'dataset'   => $outcome,
		'model'     => \App\Outcome::class,
		'groups'	=> [
			'properties' => [
				'match',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'team',
			],
			'external' => [
				'external_id',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/outcome/edit.blade.php ENDPATH**/ ?>