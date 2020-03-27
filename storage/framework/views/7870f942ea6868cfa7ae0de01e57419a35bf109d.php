<div class="form-group row">
	<label for="<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<script>
			<?php
				$ckeditor = 'ckeditor_' . $field . '_' . time();
			?>

			$(document).ready(function () {
				var <?php echo e($ckeditor); ?> = CKEDITOR.replace('<?php echo e($field); ?>');
				<?php echo e($ckeditor); ?>.on( 'change', function (ev) {
					$('#<?php echo e($field); ?>').val(<?php echo e($ckeditor); ?>.getData());
				});

				<?php echo e($ckeditor); ?>.config.allowedContent = true;
			});
		</script>
		<textarea class="form-control" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>"><?php echo e($value); ?></textarea>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-html.blade.php ENDPATH**/ ?>