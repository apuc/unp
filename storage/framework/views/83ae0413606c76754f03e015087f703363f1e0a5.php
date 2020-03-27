<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.social.show', $social->id),
		'dataset'   => $social,
		'model'     => \App\Social::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'site',
				'community',
				'icon',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/social/edit.blade.php ENDPATH**/ ?>