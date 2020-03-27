<div class="form-group row">
	<div class="col-sm-<?php echo e($colinput); ?> ml-sm-auto">
		<div class="custom-control custom-checkbox">
			<div id="<?php echo e($field); ?>-check-hidden" class="hidden">
				<input type="text" name="<?php echo e($field); ?>" value="<?php echo e($value ?? 0); ?>">
			</div>

			<input
				class="custom-control-input"

				id="<?php echo e($field); ?>-check-control"

				<?php if($value): ?>
					checked="checked"
				<?php endif; ?>

				onchange="
					if ($(this).prop('checked') == true)
						$('#<?php echo e($field); ?>-check-hidden').find('input').val(1);
					else
						$('#<?php echo e($field); ?>-check-hidden').find('input').val(0);
				"

				type="checkbox"
			>

			<label for="<?php echo e($field); ?>-check-control" class="custom-control-label">
				<?php echo app('translator')->get('field.office.' . $field); ?>
			</label>
		</div>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-checkbox.blade.php ENDPATH**/ ?>