<?php
    $values = (isset($values)) ? $values : false;
?>

<a class="btn btn-primary pull-right" onclick="
	ssCRUD()
		<?php if($values): ?>
			<?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				.setValue('<?php echo e($field); ?>', '<?php echo e($value); ?>')
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		.setAction('edit')
		.load('<?php echo e($url); ?>')
	;
" href="javascript: void(0);"><i class="fa fa-pencil"></i> <?php echo app('translator')->get('button.office.edit'); ?></a>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/toolbar/edit.blade.php ENDPATH**/ ?>