<?php $__env->startSection('content'); ?>
	<div class="card-wrap">
		<div class="sitemap">
			<?php echo Sitemap::render('vendor.site.sitemap.bootstrap4'); ?>

		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/sitemap/index.blade.php ENDPATH**/ ?>