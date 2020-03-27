<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.deal.show', $deal->id),
		'dataset'   => $deal,
		'model'     => \App\Deal::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bookmaker',
				'dealtype',
				'url',
				'cover',
				'description',
			],
			'period' => [
				'started_at',
				'finished_at',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/deal/edit.blade.php ENDPATH**/ ?>