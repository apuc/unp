<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.bannerpost.show', $bannerpost->id),
		'dataset'   => $bannerpost,
		'model'     => \App\Bannerpost::class,
		'groups'	=> [
			'properties' => [
				'banner',
				'sitesection',
				'bannerplace',
				'margin',
				'started_at',
				'finished_at',
				'view_limit',
				'view_amount',
				'click_limit',
				'click_amount',
				'is_enabled',
				'is_debug',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bannerpost/edit.blade.php ENDPATH**/ ?>