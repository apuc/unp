<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.tournament.index'),
		'dataset'   => $tournament,
		'model'     => \App\Tournament::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sport',
				'gender',
				'logo',
				'external_id',
				'tournamenttype',
				'position',
				'is_top',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/tournament/create.blade.php ENDPATH**/ ?>