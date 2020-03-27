<?php if(count($breadcrumbs)): ?>

    <nav>
        <div class="nav-wrapper">
            <div class="col s12">
                <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if($breadcrumb->url && !$loop->last): ?>
                        <a href="<?php echo e($breadcrumb->url); ?>" class="breadcrumb"><?php echo e($breadcrumb->title); ?></a>
                    <?php else: ?>
                        <span class="breadcrumb"><?php echo e($breadcrumb->title); ?></span>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </nav>

<?php endif; ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/vendor/davejamesmiller/laravel-breadcrumbs/views/materialize.blade.php ENDPATH**/ ?>