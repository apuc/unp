<?php $__env->startSection('content'); ?>
    <div class="card-wrap">
    	<h2 class="title">Документы</h2>

		<?php if($legaldocuments->count()): ?>
			<?php $__currentLoopData = $legaldocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $legaldocument): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
				<?php echo $__env->make('card.site.legal.normal', [
					'slug' 		=> $legaldocument->slug,
					'name' 		=> $legaldocument->name,
					'issued_at' => $legaldocument->issued_at,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php else: ?>
			<p>Документы не найдены</p>
		<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<?php if(filled($document = Text::get($sitesection, 'top'))): ?>
	   	<section class="text-top">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
   	<?php echo $__env->make('partial.site.sidebar.info', [
   		'current' => 'site.legal.index'
   	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
	   	<section class="text-bottom">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/legal/index.blade.php ENDPATH**/ ?>