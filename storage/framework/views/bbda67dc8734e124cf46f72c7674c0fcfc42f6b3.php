<div class="form-group row">
	<label for="<?php echo e($field . '_id'); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<select class="custom-select" id="<?php echo e($field . '_id'); ?>" name="<?php echo e($field . '_id'); ?>">
			<option value="">-- <?php echo app('translator')->get('field.office.select'); ?></option>
			<?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($option->id); ?>"<?php echo e($id == $option->id ? ' selected' : ''); ?>><?php echo e((gettype($lookup) == 'string') ? $option->$lookup : call_user_func($lookup, $option)); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-select.blade.php ENDPATH**/ ?>