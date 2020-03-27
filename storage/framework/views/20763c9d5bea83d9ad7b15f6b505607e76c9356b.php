<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.payment.index'),
		'dataset'   => $payment,
		'model'     => \App\Payment::class,
		'groups'	=> [
			'properties' => [
				'user',
				'amount',
				'paid_at',
				'purpose',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/payment/create.blade.php ENDPATH**/ ?>