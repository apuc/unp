<ul class="list-unstyled<?php echo e(false === $sitemap->root ? ' pl-3' : ''); ?>">
	<?php $__currentLoopData = $sitemap->nodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php if(true === $node->pagination): ?>
			<li class="list-inline-item"><a href="<?php echo e($node->loc); ?>"><?php echo e($node->name); ?></a></li>
		<?php else: ?>
			<li>
				<a href="<?php echo e($node->loc); ?>"><?php echo e($node->name); ?></a>

				<?php if(null !== $node->nodes && $node->nodes->count()): ?>
					<?php echo $__env->make('sitemap::bootstrap4', [
						'sitemap' => $node,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endif; ?>
			</li>
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul><?php /**PATH /var/www/sportliga/site/sportliga.com/vendor/siteset/sitemap/views/bootstrap4.blade.php ENDPATH**/ ?>