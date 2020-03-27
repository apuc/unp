<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.menuitem.show', $menuitem->id),
		'dataset'   => $menuitem,
		'model'     => \App\Menuitem::class,
		'groups'	=> [
			'properties' => [
				'name',
				'url',
				'menusection',
				'is_enabled',
				'position',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/menuitem/edit.blade.php ENDPATH**/ ?>