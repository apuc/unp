<div class="ss-crud-form">

	<?php if ($__env->exists('page.office.' . modelName($model) . '.create-scripts')) echo $__env->make('page.office.' . modelName($model) . '.create-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<form action="<?php echo e($action); ?>" method="post" onsubmit="return false;" enctype="multipart/form-data">
		<?php echo e(csrf_field()); ?>

		<?php echo $__env->make('control.office.plate.form', [
			'event'     => 'create',
			'action'    => $action,
			'dataset'   => $dataset,
			'model'		=> $model,
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</form>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/plate/create.blade.php ENDPATH**/ ?>