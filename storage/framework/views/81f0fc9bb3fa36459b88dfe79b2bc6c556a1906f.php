<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.offer.index'),
		'dataset'   => $offer,
		'model'     => \App\Offer::class,
		'groups'	=> [
			'properties' => [
				'bookmaker',
				'outcome',
				'odds_current',
				'odds_old',
				'coupon',
				'has_offers',
				'external_id',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/offer/create.blade.php ENDPATH**/ ?>