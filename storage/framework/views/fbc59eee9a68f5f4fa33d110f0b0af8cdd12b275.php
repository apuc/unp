<?php $__env->startSection('content'); ?>
    <div class="card-wrap">
    	<h2 class="title">Вопросы</h2>

    	<div class="questions-accordion accordion" id="questions">
			<?php if($helpsection->helpquestions->count()): ?>
				<?php $__currentLoopData = $helpsection->helpquestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $helpquestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="card">
						<div class="question" id="heading-<?php echo e($helpquestion->id); ?>">
							<p class="collapsed" data-toggle="collapse" data-target="#question-<?php echo e($helpquestion->id); ?>" aria-expanded="false" aria-controls="#question-<?php echo e($helpquestion->id); ?>">
								<?php echo e($helpquestion->name); ?>

							</p>
						</div>
						<div id="question-<?php echo e($helpquestion->id); ?>" class="collapse" aria-labelledby="heading-<?php echo e($helpquestion->id); ?>" data-parent="#questions">
							<div class="card-body">
								<?php echo $helpquestion->answer; ?>

							</div>
						</div>
					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>	
		</div>

		
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<?php if(filled($helpsection->text_header)): ?>
	   	<section class="text-top">
   			<?php echo $helpsection->text_header; ?>

	   	</section>
   	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.info', ['current' => 'site.help.section'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($helpsection->text_footer)): ?>
	   	<section class="text-bottom">
   			<?php echo $helpsection->text_footer; ?>

	   	</section>
   	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/help/section.blade.php ENDPATH**/ ?>