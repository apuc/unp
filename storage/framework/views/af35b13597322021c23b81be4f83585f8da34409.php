<div class="form-group row">
	<label for="f_<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<input class="form-control" type="text" id="f_<?php echo e($field); ?>" name="f_<?php echo e($field); ?>" value="<?php echo e(filled($value) ? $value->format('d.m.Y') : null); ?>">
		<script>
			jQuery.datetimepicker.setLocale('<?php echo e(config('app.locale')); ?>');
			$('#f_<?php echo e($field); ?>').datetimepicker({
				timepicker:	false,
				format:		'd.m.Y'
			});
		</script>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/filter/input-date.blade.php ENDPATH**/ ?>