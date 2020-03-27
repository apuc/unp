<?php $__env->startSection('code', 		'500'); ?>
<?php $__env->startSection('title', 		trans('error.500.title')); ?>
<?php $__env->startSection('message', 	trans('error.500.message')); ?>
<?php $__env->startSection('description', trans('error.500.description')); ?>

<?php echo $__env->make('errors.minimal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/errors/500.blade.php ENDPATH**/ ?>