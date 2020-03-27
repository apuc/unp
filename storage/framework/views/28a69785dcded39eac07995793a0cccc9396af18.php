<?php
	$value = $value ?? null;
?>
<div class="form-group row">
	<label class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<div class="custom-control custom-radio custom-control-inline">
			<input
				value=""
				name="f_<?php echo e($field); ?>"
				<?php echo empty($value) ? 'checked="checked"' : ''; ?>

				type="radio"
				class="custom-control-input"
				id="f_<?php echo e($field); ?>_all"
			>
			<label class="custom-control-label" for="f_<?php echo e($field); ?>_all"><?php echo app('translator')->get('field.office.all'); ?></label>
		</div>

		<div class="custom-control custom-radio custom-control-inline">
			<input
				value="1"
				name="f_<?php echo e($field); ?>"
				<?php echo 1 == $value ? 'checked="checked"' : ''; ?>

				type="radio"
				class="custom-control-input"
				id="f_<?php echo e($field); ?>_true"
			>
			<label class="custom-control-label" for="f_<?php echo e($field); ?>_true"><?php echo app('translator')->get('field.office.yes'); ?></label>
		</div>

		<div class="custom-control custom-radio custom-control-inline">
			<input
				value="0"
				name="f_<?php echo e($field); ?>"
				<?php echo filled($value) && 0 === (int)$value ? 'checked="checked"' : ''; ?>

				type="radio"
				class="custom-control-input"
				id="f_<?php echo e($field); ?>_false"
			>
			<label class="custom-control-label" for="f_<?php echo e($field); ?>_false"><?php echo app('translator')->get('field.office.no'); ?></label>
		</div>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/filter/input-boolean.blade.php ENDPATH**/ ?>