<?php $__env->startSection('content'); ?>
	<div class="article-detail">
		<time datetime="<?php echo e($legaldocument->issued_at->format('Y-m-d')); ?>"><?php echo app('translator')->get('message.site.legal.edition', ['issued_at' => Moment::asDate($legaldocument->issued_at)]); ?></time>

		<?php echo $legaldocument->content; ?>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.info', [
		'current' => 'site.legal.index'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/legal/show.blade.php ENDPATH**/ ?>