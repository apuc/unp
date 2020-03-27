<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.banner.index'),
		'dataset'   => $banner,
		'model'     => \App\Banner::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bannerformat',
				'bannercampaign',
				'picture',
				'link',
				'html',
				'alt',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/banner/create.blade.php ENDPATH**/ ?>