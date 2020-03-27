<?php if($paginator->hasPages()): ?>
	<nav class="pagination-box d-flex flex-column flex-md-row justify-content-between">
		<ul class="pagination pagination-sm">
			
			<?php if($paginator->onFirstPage()): ?>
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="">
						<span class="page-arrow" aria-hidden="true">&laquo;</span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" aria-label="">
						<span class="page-arrow" aria-hidden="true">&laquo;</span>
					</a>
				</li>
			<?php endif; ?>

			
			<?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				
				<?php if(is_string($element)): ?>
					<li class="page-item disabled">
						<a class="page-link" href="#" aria-label="">
							<span><?php echo e($element); ?></span>
						</a>
					</li>
				<?php endif; ?>

				
				<?php if(is_array($element)): ?>
					<?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if($page == $paginator->currentPage()): ?>
							<li class="page-item active"><a class="page-link" href="#"><?php echo e($page); ?></a></li>
						<?php else: ?>
							<li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
						<?php endif; ?>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			
			<?php if($paginator->hasMorePages()): ?>
				<li class="page-item">
					<a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" aria-label="">
						<span class="page-arrow" aria-hidden="true">&raquo;</span>
					</a>
				</li>
			<?php else: ?>
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="">
						<span class="page-arrow" aria-hidden="true">&raquo;</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>

		<div class="pagination-txt"><?php echo app('translator')->get('pagination.counter', ['first' => $paginator->firstItem(), 'last' => $paginator->lastItem(), 'total' => $paginator->total()]); ?></div>
	</nav>
<?php endif; ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/vendor/pagination/default.blade.php ENDPATH**/ ?>