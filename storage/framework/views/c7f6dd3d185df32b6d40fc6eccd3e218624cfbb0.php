<?php
    $values   = (isset($values))   ? $values   : false;
    $redirect = (isset($redirect)) ? $redirect : false;
?>

<div class="btn-group">
    <a class="btn btn-primary" onclick="ssCRUD()
        <?php if($values): ?>
            <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                .setValue('<?php echo e($field); ?>', '<?php echo e($value); ?>')
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        

        .setAction('create').load('<?php echo e($url); ?>');" href="javascript: void(0);" data-toggle="tooltip" title="<?php echo app('translator')->get('button.office.create'); ?>"><i class="fa fa-plus" aria-hidden="true"></i> <span><?php echo app('translator')->get('button.office.create'); ?></span></a>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/toolbar/create.blade.php ENDPATH**/ ?>