<div class="form-group row">
	<label for="f_<?php echo e($field . '_id'); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div id="f_<?php echo e($field); ?>" class="col-sm-<?php echo e($colinput); ?>">
		<input type="hidden" name="f_<?php echo e($field . '_id'); ?>" value="<?php echo e($id); ?>">

		<div id="f_<?php echo e($field . '_id'); ?>" class="input-group">
			<input placeholder="<?php echo app('translator')->get('field.office.select'); ?>" class="form-control ss-search-select-result" type="text" value="<?php echo e($value); ?>">
			<div class="input-group-append">
				<span class="input-group-text">
					<i class="ss-search-deselect fa fa-times"></i>
				</span>
			</div>
			<?php if(filled($create)): ?>
				<div class="input-group-append">
					<span class="input-group-text">
						<i onclick="ssCRUD().sleep().setValues().setRedirect().setAction('f_<?php echo e($field); ?>-create').load('<?php echo e($create); ?>', 'f_<?php echo e($field); ?>');" class="ss-search-create fa fa-plus"></i>
					</span>
				</div>
			<?php endif; ?>
		</div>

		<script>
			var search_f_<?php echo e($field . '_id'); ?>;

			$(document).ready(function () {
				// инициализируем поиск
				search_f_<?php echo e($field . '_id'); ?> = new ssSearch({
					obj:        '#f_<?php echo e($field); ?>',
					ajaxPath:   '<?php echo e($search); ?>',
					field:      'f_<?php echo e($field . '_id'); ?>',
					notFound:   '<?php echo app('translator')->get('field.office.notfound'); ?>',
					token:      '<?php echo e(csrf_token()); ?>'
				});

				search_f_<?php echo e($field . '_id'); ?>.init();
			});
		</script>

		<div style="display: none;" class="ss-search-list-box dropdown-menu">
			<input id="f_<?php echo e($field . '_enter'); ?>" class="form-control ss-search-field" type="text" value="">

			<div class="ss-search-list">
				<ul></ul>
			</div>
		</div>
		<div class="hidden ss-search-keyboard-name"></div>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/filter/input-search.blade.php ENDPATH**/ ?>