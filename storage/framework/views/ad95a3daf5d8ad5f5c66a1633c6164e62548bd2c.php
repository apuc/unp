<?php $__env->startSection('columns'); ?>
	<?php echo Breadcrumbs::render($route, Crumb::params()); ?>


	<h1><?php echo e(Crumb::caption()); ?></h1>

	<?php if (! empty(trim($__env->yieldContent('top')))): ?>
		<?php echo $__env->yieldContent('top'); ?>
	<?php endif; ?>

	<div class="row">
		<div class="content">
			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<div class="sidebar">
			<?php echo $__env->yieldContent('sidebar'); ?>
			<?php echo $__env->renderWhen(config('show.banner.sidebar'), 'partial.site.bulletin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path'])); ?>
		</div>
	</div>

	<?php if (! empty(trim($__env->yieldContent('bottom')))): ?>
		<?php echo $__env->yieldContent('bottom'); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/layout/site/grid/double.blade.php ENDPATH**/ ?>