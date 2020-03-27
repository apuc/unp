<?php $__env->startSection('content'); ?>
    <div class="card card-detail">
    	<div class="card-header">
    		<span class="name"><a href="<?php echo e(route('site.bookmaker.index')); ?>">Букмекеры</a> / <a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>"><?php echo e($bookmaker->name); ?></a></span>
    		
		</div>
    	<div class="card-body">
    		<figure>
    			<img src="<?php echo e(asset('preview/782/274/storage/bookmakers/' . $bookmaker->cover)); ?>" alt="<?php echo e($bookmaker->name); ?>" class="img-fluid">
			</figure>
			<?php echo $bookmaker->description; ?>


    	</div>
	</div>

	<?php if($bookmaker->deals->count()): ?>
		<div class="card-wrap">
   	   		<h2 class="title">Акции</h2>
			<?php $__currentLoopData = $bookmaker->deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	            <div class="cards_list">
					<?php echo $__env->make('card.site.deal.normal', [
						'deal' => $deal,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.bookmaker', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/bookmaker/show.blade.php ENDPATH**/ ?>