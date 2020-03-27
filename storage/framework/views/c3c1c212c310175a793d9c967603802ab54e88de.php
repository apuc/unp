<!DOCTYPE html>
<html class="html-popup" lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo e(Crumb::title()); ?></title>
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" href="<?php echo e(asset('/favicon.ico')); ?>" type="image/x-icon">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo $__env->make('partial.site.metatags', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(mix('/assets/site/css/app.css')); ?>">
	<script src="<?php echo e(mix('/assets/site/js/app.js')); ?>"></script>
	<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $counter->code_head; ?>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</head>
<body
	<?php if(config('show.banner.branding')): ?>
		class="bg-branding-bulletin"
	<?php endif; ?>
>
	<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $counter->code_top; ?>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php echo $__env->renderWhen(config('show.banner.branding'), 'partial.site.bulletin.branding', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
	<div class="wrap-container container">
		<?php echo $__env->make('partial.site.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->renderWhen(config('show.banner.top'), 'partial.site.bulletin.top', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		<div class="page-content">
			<?php echo $__env->yieldContent('columns'); ?>
			<?php echo $__env->renderWhen(config('show.banner.bottom'), 'partial.site.bulletin.bottom', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		</div>
		<?php echo $__env->make('partial.site.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
	<?php echo $__env->make('partial.site.logon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php echo $counter->code_script; ?>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</body>
</html><!-- <?php echo e(config('app.name')); ?> v<?php echo e(config('app.version')); ?> --><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/layout/site/app.blade.php ENDPATH**/ ?>