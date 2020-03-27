<?php if(count($breadcrumbs)): ?>
    <ul class="uk-breadcrumb">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($loop->last): ?>
                <li><span><?php echo e($breadcrumb->title); ?></span></li>
            <?php elseif($breadcrumb->url): ?>
                <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
            <?php else: ?>
                <li class="uk-disabled"><a><?php echo e($breadcrumb->title); ?></a></li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/vendor/davejamesmiller/laravel-breadcrumbs/views/uikit.blade.php ENDPATH**/ ?>