<div class="form-group row">
	<label for="<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<textarea <?php echo filled($readonly) ? 'readonly="readonly"' : ''; ?> rows="8" class="form-control" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>"><?php echo e($value); ?></textarea>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-textarea.blade.php ENDPATH**/ ?>