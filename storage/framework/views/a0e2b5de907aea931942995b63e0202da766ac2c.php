<?php $__env->startSection('content'); ?>
	<div class="card card-detail forecasts-detail forecasts-detail--<?php echo e($forecast->forecaststatus->slug); ?>" id="description">
		<div class="card-header">
			<span class="name"><a href="<?php echo e(route('site.forecast.index')); ?>">Прогнозы</a> / <a href="<?php echo e(route('site.forecast.index', ['sport' => $forecast->sport->slug])); ?>"><?php echo e($forecast->sport->name); ?></a></span>
			
		</div>
		<div class="card-body">
			<div class="forecasts-detail__participants">
				<div class="forecasts-detail__participant">
					<?php if(null !== $forecast->match->participants[0]->team->logo): ?>
						<div class="forecasts-detail__participant-img">
							<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $forecast->match->participants[0]->team->logo)); ?>" alt="<?php echo e($forecast->match->participants[0]->team->name); ?>">
						</div>
					<?php endif; ?>
					<h3><?php echo e($forecast->match->participants[0]->team->name); ?></h3>
   				</div>

				<div class="forecasts-detail__score">
					<?php if(in_array($forecast->match->matchstatus->slug, ['finished', 'inprogress'])): ?>
   						<div class="forecasts-detail__score-1"><?php echo e($forecast->match->participants[0]->score); ?></div>
   						<div class="forecasts-detail__score-2"><?php echo e($forecast->match->participants[1]->score); ?></div>
   					<?php endif; ?>
				</div>

				<div class="forecasts-detail__participant">
					<?php if(null !== $forecast->match->participants[1]->team->logo): ?>
						<div class="forecasts-detail__participant-img">
							<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $forecast->match->participants[1]->team->logo)); ?>" alt="<?php echo e($forecast->match->participants[1]->team->name); ?>">
						</div>
					<?php endif; ?>
					<h3><?php echo e($forecast->match->participants[1]->team->name); ?></h3>
   				</div>
			</div>

			<div class="forecasts-detail__hd">
				<p class="text-uppercase">
					<span><?php echo e($forecast->match->stage->season->tournament->name); ?></span>
					&mdash;
					<span><?php echo e($forecast->match->stage->season->name); ?></span>
					<?php if(false === mb_strpos(mb_strtolower($forecast->match->stage->season->tournament->name), mb_strtolower($forecast->match->stage->name))): ?>
						&mdash;
						<span><?php echo e($forecast->match->stage->name); ?></span>
					<?php endif; ?>
				</p>
				<p>Начало игры: <?php echo e($forecast->match->started_at->format('d.m.Y H:i')); ?></p>
			</div>

			<div class="forecasts-detail__val">
    			<div class="forecasts-detail__val-item">
    				Исход:
    				<b><?php echo e($forecast->outcometype->name); ?></b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Время:
    				<b><?php echo e($forecast->outcomescope->name); ?></b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Прогноз:
    				<b><?php echo e(parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name])); ?></b>
    			</div>
    			
    			<div class="forecasts-detail__val-item">
    				Ставка:
    				<b><?php echo e($forecast->bet); ?> баллов</b>
    			</div>
    			<div class="forecasts-detail__val-item">
    				Букмекер:
        			<a href="<?php echo e($forecast->bookmaker->site); ?>" class="bookmaker">
        				<?php if(null !== $forecast->bookmaker->logo): ?>
        					<img src="<?php echo e(asset('preview/64/26/storage/bookmakers/' . $forecast->bookmaker->logo)); ?>" alt="<?php echo e($forecast->bookmaker->name); ?>">
        				<?php else: ?>
        					<?php echo e($forecast->bookmaker->name); ?>

        				<?php endif; ?>
        			</a>
				</div>
    			<div class="forecasts-detail__val-item">
    				Коэффициент:
                	<b><?php echo e($forecast->rate); ?></b>
				</div>
                <div class="forecasts-detail__val-item">
    				Результат:
                	<div class="result"><?php echo e($forecast->forecaststatus->name); ?></div>
                </div>
			</div>
			<?php if(null !== $forecast->description): ?>
				<div class="forecasts-detail__comment">
					<p><?php echo nl2br($forecast->description); ?></p>
				</div>
			<?php endif; ?>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				<a href="<?php echo e(route('site.forecast.show', ['forecast' => $forecast->id])); ?>#comment" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($forecast->forecastcomments_count); ?></a>
			</div>
			<div class="card-user">
				<div class="user-name">
					<a href="<?php echo e(route('site.user.show', ['login' => $forecast->user->login])); ?>"><?php echo e($forecast->user->nickname); ?></a>
					<time><?php echo e($forecast->posted_at->format('d.m.Y H:i')); ?></time>
				</div>
				<div class="user-img"><a href="<?php echo e(route('site.user.show', ['login' => $forecast->user->login])); ?>"><img src="<?php echo e(asset('preview/200/200/storage/users/' . $forecast->user->avatar)); ?>" alt="<?php echo e($forecast->user->nickname); ?>"></a></div>
			</div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/show.blade.php ENDPATH**/ ?>