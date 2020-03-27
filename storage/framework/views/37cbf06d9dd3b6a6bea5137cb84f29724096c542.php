<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo e(mix('/assets/office/css/app.css')); ?>">
    <script src="<?php echo e(mix('/assets/office/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('/assets/office/js/ckeditor/ckeditor.js')); ?>"></script>
</head>
<body>
<?php echo $__env->yieldContent('content'); ?>
</body>
</html><!-- <?php echo e(config('app.name')); ?> v<?php echo e(config('app.version')); ?> -->
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/layout/office/blank.blade.php ENDPATH**/ ?>