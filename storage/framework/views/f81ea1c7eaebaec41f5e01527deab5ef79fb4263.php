<div class="form-group row">
	<label for="<?php echo e($field); ?>" class="col-sm-<?php echo e($collabel); ?> col-form-label"><?php echo app('translator')->get('field.office.' . $field); ?></label>
	<div class="col-sm-<?php echo e($colinput); ?>">
		<div class="row">
			<?php if('create' == $event || null === $value->$field): ?>
				<div class="col-sm-12">
					<div data-custom-filebrowse="<?php echo e($field); ?>">
						<div class="btn btn-light">
							<i class="fa fa-upload" aria-hidden="true"></i> <?php echo app('translator')->get('button.office.upload'); ?>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-check" aria-hidden="true"></i> <span></span>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<input type="file" class="hidden" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>">
					</div>
				</div>
			<?php else: ?>
				<div class="col-sm-2">
					<?php
						$folder = str_plural(mb_strtolower(class_basename(get_class($value))));
						switch(mb_strtolower(pathinfo($value->$field, PATHINFO_EXTENSION))) {
							case 'jpg':
							case 'jpeg':
							case 'gif':
							case 'png':
							case 'bmp':
								$content = ''
									. '<a class="siteset-gallery" href="' . Storage::disk('public')->url($folder . '/' . $value->$field) . '">'
										. '<img src="' . asset('/preview/40/40/storage/' . $folder . '/' . $value->$field) . '" alt="">'
									. '</a>'
								;
								break;
							default:
								$content = ''
									. '<a href="' . Storage::disk('public')->url($folder . '/' . $value->$field) . '" target="_blank">'
										. trans('office.downloadfile')
									. '</a>'
								;
								break;
						}
					?>

					<?php echo $content; ?>

				</div>
				<div class="col-sm-10">
					<div data-checkboxgroup="<?php echo e($field); ?>" <?php echo $required ? 'class="hidden"' : ''; ?>>
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" id="<?php echo e($field); ?>_clean" name="<?php echo e($field); ?>_clean" type="checkbox">
							<label for="<?php echo e($field); ?>_clean" class="custom-control-label">
								<?php echo app('translator')->get('button.office.delete'); ?>
							</label>
						</div>

						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" id="<?php echo e($field); ?>_update" type="checkbox">
							<label for="<?php echo e($field); ?>_update" class="custom-control-label">
								<?php echo app('translator')->get('button.office.update'); ?>
							</label>
						</div>
					</div>

					<div data-custom-filebrowse="<?php echo e($field); ?>" <?php echo !$required ? 'class="hidden"' : ''; ?>>
						<div class="btn btn-light">
							<i class="fa fa-upload" aria-hidden="true"></i> <?php echo app('translator')->get('button.office.upload'); ?>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-check" aria-hidden="true"></i> <span></span>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<input type="file" class="hidden" id="<?php echo e($field); ?>" name="<?php echo e($field); ?>">
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
	var sitesetFilebrowseVariable_<?php echo e($field); ?>;
	var sitesetCheckboxgroupVariable_<?php echo e($field); ?>;
	$(document).ready(function () {
		sitesetFilebrowseVariable_<?php echo e($field); ?> = ssFB('<?php echo e($field); ?>', {
			'browse':	'.btn-light:nth-child(1)',
			'rebrowse':	'.btn-light:nth-child(2)',
			'clear':	'.btn-light:nth-child(3)',
		});
		sitesetFilebrowseVariable_<?php echo e($field); ?>.init();

		sitesetCheckboxgroupVariable_<?php echo e($field); ?> = ssCheckbox('<?php echo e($field); ?>', {
			1: {
				'activated': function () {
					$("div[data-custom-filebrowse='<?php echo e($field); ?>']").removeClass('hidden');
				},
				'deactivated': function () {
					$("div[data-custom-filebrowse='<?php echo e($field); ?>']").addClass('hidden');
				}
			}
		});
		sitesetCheckboxgroupVariable_<?php echo e($field); ?>.init();
	});
</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/form/input-attachment.blade.php ENDPATH**/ ?>