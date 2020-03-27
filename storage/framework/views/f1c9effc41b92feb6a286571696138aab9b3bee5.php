<?php $__env->startSection('content'); ?>

	<form action="<?php echo e(route('debug.match.index')); ?>" method="get">
		<input type="text" data-mask="9999-99-99" data-mask-handler="integer" name="started_at" value="<?php echo e(request()->started_at); ?>">
		<input type="submit">
	</form>

	<?php if($dataset->count()): ?>
		<?php $__currentLoopData = $dataset; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<h2><?php echo e($data['sport']->name); ?> (<?php echo e($data['sport']->main_name); ?>)</h2>

			<?php $__currentLoopData = $data['tournaments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<h4><?php echo e($tournament['tournament']->name ?? $tournament['tournament']->external_name); ?> (<?php echo e($tournament['tournament']->main_name); ?>)</h3>

				<?php $__currentLoopData = $tournament['matches']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div>
						<a href="<?php echo e(route('debug.match.show', ['match' => $match->id])); ?>" target="_blank"><?php echo e($match->name ?? $match->external_name); ?></a>
						/ <?php echo e($match->bookmaker1_name); ?> 1: <?php echo e($match->odds1_current ?? '0.00'); ?>

						/ <?php echo e($match->bookmakerx_name); ?> X: <?php echo e($match->oddsx_current ?? '0.00'); ?>

						/ <?php echo e($match->bookmaker2_name); ?> 2: <?php echo e($match->odds2_current ?? '0.00'); ?>

					</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.debug', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/debug/match/index.blade.php ENDPATH**/ ?>