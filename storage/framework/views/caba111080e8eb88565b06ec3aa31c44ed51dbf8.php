<?php
	$value = $value ?? [null, null];
?>
<div class="form-group row">
	<label for="f_<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<div id="f_<?php echo e($field); ?>" class="input-group">
			<input class="form-control input-range" type="text" id="f_<?php echo e($field); ?>0" name="f_<?php echo e($field); ?>[0]" value="<?php echo e(filled($value[0]) ? $value[0]->format('d.m.Y H:i:s') : null); ?>">
			&nbsp;&ndash;&nbsp;
			<input class="form-control input-range" type="text" id="f_<?php echo e($field); ?>1" name="f_<?php echo e($field); ?>[1]" value="<?php echo e(filled($value[1]) ? $value[1]->format('d.m.Y H:i:s') : null); ?>">
		</div>

		<script>
			jQuery.datetimepicker.setLocale('<?php echo e(config('app.locale')); ?>');
			$('#f_<?php echo e($field); ?>0').datetimepicker({
				format: 'd.m.Y H:i:s'
			});
			$('#f_<?php echo e($field); ?>1').datetimepicker({
				format: 'd.m.Y H:i:s'
			});
		</script>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/filter/input-datetimerange.blade.php ENDPATH**/ ?>