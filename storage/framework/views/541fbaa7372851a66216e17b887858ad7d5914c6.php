<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.sport.show', $sport->id),
		'dataset'   => $sport,
		'model'     => \App\Sport::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'icon',
				'has_odds',
				'position',
				'external_id',
				'external_name',
				'is_enabled',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sport/edit.blade.php ENDPATH**/ ?>