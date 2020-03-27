<?php if(count($breadcrumbs)): ?>

    <ul class="breadcrumb">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->last): ?>

                <li class="active">
                    <?php echo e($breadcrumb->title); ?>

                </li>

            <?php elseif($breadcrumb->url): ?>

                <li>
                    <a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a>
                    <span class="divider">/</span>
                </li>

            <?php else: ?>

                
                <li class="active">
                    <?php echo e($breadcrumb->title); ?>

                    <span class="divider">/</span>
                </li>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

<?php endif; ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/vendor/davejamesmiller/laravel-breadcrumbs/views/bootstrap2.blade.php ENDPATH**/ ?>