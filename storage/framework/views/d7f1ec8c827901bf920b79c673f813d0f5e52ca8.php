<?php
	$value	= $value ?? [null, null];
	$mask	= $mask ?? null;
?>
<div class="form-group row">
	<label for="f_<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<div id="f_<?php echo e($field); ?>" class="input-group">
			<input <?php echo filled($mask) ? 'data-mask="' . $mask . '"' : ''; ?> class="form-control input-range" type="text" id="f_<?php echo e($field); ?>0" name="f_<?php echo e($field); ?>[0]" value="<?php echo e($value[0]); ?>">
			&nbsp;&ndash;&nbsp;
			<input <?php echo filled($mask) ? 'data-mask="' . $mask . '"' : ''; ?> class="form-control input-range" type="text" id="f_<?php echo e($field); ?>1" name="f_<?php echo e($field); ?>[1]" value="<?php echo e($value[1]); ?>">
		</div>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/filter/input-textrange.blade.php ENDPATH**/ ?>