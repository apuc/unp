<?php
	$values 	= $values ?? false;
	$hide   	= $hide ?? [];
	$model_name	= modelName($model);
	$tab_name   = mb_strtolower(str_plural($tab ?? $model_name));
	$can_create = $can['create'] ?? auth()->user()->can('create', $model);
?>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('index', $model)): ?>
	<div class="tab-pane" id="<?php echo e($tab_name); ?>">
		<div class="box-header">
			<div class="clearfix">
				<?php if($can_create): ?>
					<?php echo $__env->make('control.office.toolbar.create', [
						'url'    => route("office.{$model_name}.create"),
						'values' => $values,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
				<?php echo $__env->make('control.office.toolbar.dataset', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>

			<?php echo $__env->make('control.office.toolbar.filter-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div>

		<?php echo $__env->make('control.office.toolbar.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<?php echo $__env->make('control.office.plate.index', [
			'dataset'			=> $dataset,
			'model'				=> $model,
			'fields'			=> $fields,
			'values'			=> $values,
			'nested'			=> true,
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
<?php endif; ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/plate/nested-index.blade.php ENDPATH**/ ?>