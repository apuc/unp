<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.match.show', $match->id),
		'dataset'   => $match,
		'model'     => \App\Match::class,
		'groups'	=> [
			'properties' => [
				'name',
				'stage',
				'started_at',

				'bookmaker1',
				'odds1_current',
				'odds1_old',

				'bookmakerx',
				'oddsx_current',
				'oddsx_old',

				'bookmaker2',
				'odds2_current',
				'odds2_old',

				'external_id',

				'matchstatus',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/match/edit.blade.php ENDPATH**/ ?>