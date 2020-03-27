<?php $__env->startSection('content'); ?>
    <div class="card card-detail user-detail" id="info">
    	<div class="card-body">
    		<h2><?php echo e($user->nickname); ?></h2>

    		<div class="row align-items-center user-detail-top">
    			<div class="col-4 text-center">
    				<b>На сайте с</b><br>
    				<?php echo e(Moment::asDate($user->created_at)); ?>

    			</div>
    			<div class="col-4 text-center">
    				<div class="user-detail-avatar"><img src="<?php echo e(asset('preview/96/96/storage/users/' . $user->avatar)); ?>" alt="<?php echo e($user->nickname); ?>"></div>
    			</div>
    			<div class="col-4 text-center">
    				
    			</div>
    		</div>

    		<div class="row">
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Прогнозов<br><b><?php echo e($user->stat_forecasts); ?></b>
    				</div>
    			</div>
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Комментариев<br><b><?php echo e($user->stat_comments); ?></b>
    				</div>
    			</div>
    			<div class="col-12 col-md-4 text-center">
    				<div class="user-detail-info">
    					Баллов<br><b><?php echo e($user->balance); ?></b>
    				</div>
    			</div>
    			<div class="col-12 col-md-6 text-center">
    				<div class="user-detail-info">
    					Новостей<br><b><?php echo e($user->stat_briefs); ?></b>
    				</div>
    			</div>
    			<div class="col-12 col-md-6 text-center">
    				<div class="user-detail-info">
    					Статей<br><b><?php echo e($user->stat_posts); ?></b>
    				</div>
    			</div>
			</div>
			<?php if(null !== $user->about): ?>
			<div class="card-text">
				<?php echo nl2br(e($user->about)); ?>

			</div>
			<?php endif; ?>
    	</div>
    </div>

	<div class="card-wrap user-detail-finance" id="finance">
   		<h2 class="title">Финансы</h2>
		<div class="btn-group nav nav-pills" role="tablist">
			<a class="btn btn-secondary active" id="30-days-tab" data-toggle="pill" href="#30-days" role="tab" aria-controls="today" aria-selected="true">За 30 дней</a>
			<a class="btn btn-secondary" id="all-time-tab" data-toggle="pill" href="#all-time" role="tab" aria-controls="all-time" aria-selected="false">Всё время</a>
		</div>
		<div class="tab-content card">
			<div class="tab-pane fade show active" id="30-days" role="tabpanel" aria-labelledby="30-days-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
			<div class="tab-pane fade" id="all-time" role="tabpanel" aria-labelledby="all-time-tab">
   				<img src="storage/profile/grafik.gif" alt="" class="img-fluid" width="100%">
			</div>
		</div>
	</div>

	<?php if($profits->count()): ?>
		<div class="card-wrap" id="profit">
			<h2 class="title">Прибыль</h2>
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
		</div>
	<?php endif; ?>

	<?php if($user->forecasts->count()): ?>
		<div class="card-wrap" id="forecast">
			<h2 class="title">Последние прогнозы</h2>

			<div class="cards_list d-none d-md-block">
				<?php $__currentLoopData = $user->forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.forecast.normal', [
						'forecast' => $forecast,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>

			
			<div class="cards_tile d-block d-md-none">
				<?php $__currentLoopData = $user->forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.forecast.normal', [
						'forecast' => $forecast,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>

		</div>
	<?php endif; ?>

	<?php if($user->posts->count()): ?>
		<div class="card-wrap" id="publication">
			<h2 class="title">Последние статьи</h2>

			<div class="cards_list d-none d-md-block">
				<?php $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.post.normal', [
						'post' => $post,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>

			
			<div class="cards_tile d-block d-md-none">
				<?php $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.post.normal', [
						'post' => $post,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if($user->briefs->count()): ?>
		<div class="card-wrap" id="publication">
			<h2 class="title">Последние новости</h2>

			<div class="cards_list d-none d-md-block">
				<?php $__currentLoopData = $user->briefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.brief.normal', [
						'brief' => $brief,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>

			
			<div class="cards_tile d-block d-md-none">
				<?php $__currentLoopData = $user->briefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php echo $__env->make('card.site.brief.normal', [
						'brief' => $brief,
					], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/user/show.blade.php ENDPATH**/ ?>