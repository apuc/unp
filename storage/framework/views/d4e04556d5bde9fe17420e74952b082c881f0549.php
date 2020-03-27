<a href="<?php echo e(route('site.forecast.show', ['forecast' => $forecast->id])); ?>" class="card forecast-card forecast-card--<?php echo e($forecast->forecaststatus->slug); ?>">
	<div class="card-header">
		<span class="name"><object><a href="<?php echo e(route('site.forecast.index')); ?>">Прогнозы</a></object> / <object><a href="<?php echo e(route('site.forecast.index', ['sport' => $forecast->sport->slug])); ?>"><?php echo e($forecast->sport->name); ?></a></object></span>
		
	</div>
	<div class="card-body">
		<div class="card-subtitle">
			<span><?php echo e($forecast->match->stage->season->tournament->name); ?></span>
			<?php if(false === mb_strpos(mb_strtolower($forecast->match->stage->season->tournament->name), mb_strtolower($forecast->match->stage->name))): ?>
				&mdash;
				<span><?php echo e($forecast->match->stage->name); ?></span>
			<?php endif; ?>
		</div>
		<div class="forecast-card__participants">
			<div class="forecast-card__participant">
				<h4><?php echo e($forecast->match->participants[0]->team->name); ?></h4>
				<?php if(null !== $forecast->match->participants[0]->team->logo): ?>
					<img src="<?php echo e(asset('preview/30/30/storage/teams/' . $forecast->match->participants[0]->team->logo)); ?>" alt="<?php echo e($forecast->match->participants[0]->team->name); ?>">
				<?php endif; ?>
			</div>
			<div class="forecast-card__score">
				<?php if(in_array($forecast->match->matchstatus->slug, ['finished', 'inprogress'])): ?>
					<span class="forecast-card__score-1"><?php echo e($forecast->match->participants[0]->score); ?></span> -
					<span class="forecast-card__score-2"><?php echo e($forecast->match->participants[1]->score); ?></span>
				<?php else: ?>
					<span class="forecast-card__score-1">?</span> -
					<span class="forecast-card__score-2">?</span>
				<?php endif; ?>
			</div>
			<div class="forecast-card__participant">
				<?php if(null !== $forecast->match->participants[1]->team->logo): ?>
					<img src="<?php echo e(asset('preview/30/30/storage/teams/' . $forecast->match->participants[1]->team->logo)); ?>" alt="<?php echo e($forecast->match->participants[1]->team->name); ?>">
				<?php endif; ?>
				<h4><?php echo e($forecast->match->participants[1]->team->name); ?></h4>
			</div>
		</div>
		<div>
			<time><?php echo e($forecast->match->started_at->format('d.m.Y H:i')); ?></time>
		</div>
		<div class="forecast-card__val">
			<div class="sm"><b><?php echo e($forecast->outcometype->name); ?></b></div>
			<div class="sm"><?php echo e($forecast->outcomescope->name); ?></div>
			<div class="bold prognosis"><?php echo e(parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name])); ?></div>
			
			<div class="bold rate"><?php echo e($forecast->bet); ?> баллов</div>
			<object><a href="<?php echo e($forecast->bookmaker->site); ?>" class="bookmaker" target="_blank" rel="nofollow">
				<?php if(null !== $forecast->bookmaker->logo): ?>
					<img src="<?php echo e(asset('preview/64/26/storage/bookmakers/' . $forecast->bookmaker->logo)); ?>" alt="<?php echo e($forecast->bookmaker->name); ?>">
				<?php else: ?>
					<?php echo e($forecast->bookmaker->name); ?>

				<?php endif; ?>
			</a></object>
            <div class="odds"><span class="badge badge-light">К: <?php echo e($forecast->rate); ?></span></div>
            <div class="result">
            	<?php if($forecast->forecaststatus->slug == 'confirmed'): ?> 
            		&nbsp;
            	<?php else: ?>
            		<?php echo e($forecast->forecaststatus->name); ?>

            	<?php endif; ?>
            </div>
		</div>
		<div class="forecast-btn">
			<object><a class="btn btn-more" href="<?php echo e(route('site.forecast.show', ['forecast' => $forecast->id])); ?>">Подробнее</a></object>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<object><a class="btn btn-light" href="<?php echo e(route('site.forecast.show', ['forecast' => $forecast->id])); ?>">Подробнее</a></object>
			<object><a href="<?php echo e(route('site.forecast.show', ['forecast' => $forecast->id])); ?>#comment" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($forecast->forecastcomments_count); ?></a></object>
		</div>
		<div class="card-user">
			<div class="user-name">
				<object><a href="<?php echo e(route('site.user.show', ['login' => $forecast->user->login])); ?>"><?php echo e($forecast->user->nickname); ?></a></object>
				<time><?php echo e($forecast->posted_at->format('d.m.Y H:i')); ?></time>
			</div>
			<div class="user-img"><object><a href="<?php echo e(route('site.user.show', ['login' => $forecast->user->login])); ?>"><img src="<?php echo e(asset('preview/33/33/storage/users/' . $forecast->user->avatar)); ?>" alt="<?php echo e($forecast->user->nickname); ?>"></a></object></div>
		</div>
	</div>
</a><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/forecast/normal.blade.php ENDPATH**/ ?>