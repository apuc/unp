<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.bookmaker.index'),
		'dataset'   => $bookmaker,
		'model'     => \App\Bookmaker::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'logo',
				'cover',
				'bonus',
				'announce',
				'description',
				'site',
				'phone',
				'email',
				'address',
				'external_id',
				'position',
				'is_enabled',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bookmaker/create.blade.php ENDPATH**/ ?>