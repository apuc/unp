<?php $__env->startSection('content'); ?>
    <div class="card-wrap">
    	<h2 class="title">Разделы справки</h2>
		<?php if($helpsections->count()): ?>
    		<div class="row category-list">
    			<?php $__currentLoopData = $helpsections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helpsection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    				<div class="col-12 col-md-4 category-list__item">
            			<div class="card">
            				<div class="card-body">
            					<a href="<?php echo e(route('site.help.section', ['section' => $helpsection->slug])); ?>">
            						<img src="<?php echo e(asset('preview/96/96/storage/helpsections/' . $helpsection->icon)); ?>" alt="<?php echo e($helpsection->name); ?>" class="img-fluid">
            						<h3><?php echo e($helpsection->name); ?></h3>
								</a>
            				</div>
            			</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		<?php else: ?>
			<p>Информация для раздела подготавливается</p>
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
		'current' => 'site.help.index'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
	   	<section class="text-bottom">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/help/index.blade.php ENDPATH**/ ?>