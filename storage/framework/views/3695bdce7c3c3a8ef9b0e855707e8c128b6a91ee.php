<?php $__env->startSection('content'); ?>
    <div class="card deals-card card-detail">
    	<div class="card-header">
    		<span class="name"><a href="<?php echo e(route('site.deal.index')); ?>">Акции</a> / <a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $deal->bookmaker->slug])); ?>"><?php echo e($deal->bookmaker->name); ?></a></span>
    		
    	</div>
    	<div class="card-body">
    		<figure class="text-center mb-0">
    			<img src="<?php echo e(asset('preview/782/434/storage/deals/' . $deal->cover)); ?>" alt="<?php echo e($deal->name); ?>" class="img-fluid">
			</figure>
    	</div>
    	<div class="card-footer">
    		<a class="btn btn-light" href="<?php echo e($deal->url); ?>">Участвовать</a>
    	</div>
    </div>

	<div class="card-wrap" id="condition">
   		<h2 class="title">УСЛОВИЯ АКЦИИ</h2>
   		<?php echo $deal->description; ?>

	</div>

	

	<?php if($deals->count()): ?>
		<div class="card-wrap">
   	   		<h2 class="title">Другие акции букмекера</h2>
			<?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>        
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
	<?php echo $__env->make('partial.site.sidebar.deal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/deal/show.blade.php ENDPATH**/ ?>