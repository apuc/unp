<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.menusection.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $menusection)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.menusection.edit', [
						'menusection' => $menusection->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $menusection,
				'model'		=> \App\Menusection::class,
				'groups'	=> [
					'properties' => [
						'name',
						'url',
						'is_enabled',
						'position',
						'menuitems_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Menuitem::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $menuitems,
				'model'		=> \App\Menuitem::class,
				'fields'	=> [
					'name',
					'url',
					'is_enabled',
					'position',
				],
				'values'	=> [
					'menusection_id' => $menusection->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/menusection/show.blade.php ENDPATH**/ ?>