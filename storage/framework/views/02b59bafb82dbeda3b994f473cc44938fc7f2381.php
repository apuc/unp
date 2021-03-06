<?php
	$mask = $mask ?? null;
?>

<div class="form-group row">
	<label for="<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<input <?php echo filled($mask) ? 'data-mask="' . $mask . '"' : ''; ?> <?php echo filled($readonly) ? 'readonly="readonly"' : ''; ?> class="form-control" type="text" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>" value="<?php echo e($value); ?>">
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-text.blade.php ENDPATH**/ ?>