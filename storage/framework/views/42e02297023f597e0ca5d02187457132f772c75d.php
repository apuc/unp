<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('partial.site.panel.forecast.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partial.site.panel.forecast.sort', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div data-ss-pn-content>
		<?php if($forecasts['rows']->count()): ?>
			<div class="cards-box <?php echo e($forecasts['view'] == 0 ? 'cards_tile' : 'cards_list'); ?>">
				<div class="row">
					<?php $__currentLoopData = $forecasts['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col-12 col-md-6 col-xl-4">
							<?php echo $__env->make('card.site.forecast.normal', [
								'forecast' => $forecast,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<section class="text-top">
		<div class="row">
			<div class="text-top__btn">
				<a href="<?php echo e(route('account.forecast.create')); ?>" class="btn btn-primary btn-lg mb-3 mb-lg-0"><i class="fa fa-plus" aria-hidden="true"></i> Сделать прогноз</a>
			</div>
			<div class="col">
				&nbsp;
			</div>
		</div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.account.sidebar.forecasts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/index.blade.php ENDPATH**/ ?>