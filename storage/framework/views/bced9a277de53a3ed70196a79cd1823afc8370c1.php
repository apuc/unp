<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.bookmakertext.index'),
		'dataset'   => $bookmakertext,
		'model'     => \App\Bookmakertext::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'bookmaker',
				'picture',
				'announce',
				'content',
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


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bookmakertext/create.blade.php ENDPATH**/ ?>