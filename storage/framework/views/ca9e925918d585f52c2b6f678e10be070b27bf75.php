<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.legaldocument.show', $legaldocument->id),
		'dataset'   => $legaldocument,
		'model'     => \App\Legaldocument::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'announce',
				'position',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/legaldocument/edit.blade.php ENDPATH**/ ?>