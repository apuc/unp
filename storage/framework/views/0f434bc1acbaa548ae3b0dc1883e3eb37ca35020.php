<?php $__env->startSection('columns'); ?>
	<div data-ss-profits-content>
		<?php if($profits->count()): ?>
			<div class="card">
				<div class="table-responsive">
					<table class="table table-sm table-hover">
						<tr>
							<th>Период</th>
							<th>Прибыль</th>
							<th>Прогнозов</th>
							<th>Выиграл</th>
							<th>Проиграл</th>
							<th>Отменил</th>
							<th>Средний кэф</th>
							<th>%выигрышей</th>
							<th>ROI</th>
						</tr>
						<?php $__currentLoopData = $profits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $profit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php if(null !== $profit): ?>
								<tr>
									<td><?php echo app('translator')->get('months.' . now()->parse($month . '-01')->format('m')); ?> <?php echo e(now()->parse($month . '-01')->format('Y')); ?></td>
									<td><?php echo e($profit['profit']); ?>%</td>
									<td><?php echo e($profit['forecasts']); ?></td>
									<td><?php echo e($profit['wins']); ?></td>
									<td><?php echo e($profit['losess']); ?></td>
									<td><?php echo e($profit['draws']); ?></td>
									<td><?php echo e($profit['offer']); ?></td>
									<td><?php echo e($profit['luck']); ?>%</td>
									<td><?php echo e($profit['roi']); ?>%</td>
								</tr>
							<?php else: ?>
								<tr>
									<td><?php echo app('translator')->get('months.' . now()->parse($month . '-01')->format('m')); ?> <?php echo e(now()->parse($month . '-01')->format('Y')); ?></td>
									<td colspan="8" class="text-center">Данных нет</td>
								</tr>

							<?php endif; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</table>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/dashboard/profit.blade.php ENDPATH**/ ?>