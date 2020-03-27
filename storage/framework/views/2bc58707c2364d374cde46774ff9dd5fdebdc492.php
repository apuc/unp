<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.sitetext.show', $sitetext->id),
		'dataset'   => $sitetext,
		'model'     => \App\Sitetext::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'sitesection',
				'title',
				'picture',
				'announce',
				'content',
				'is_enabled',
				'position',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sitetext/edit.blade.php ENDPATH**/ ?>