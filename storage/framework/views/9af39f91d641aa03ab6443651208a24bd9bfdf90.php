<a href="<?php echo e(route('site.match.show', ['match' => $match->id])); ?>" class="card event-card">
	<div class="card-header">
		<span class="name"><object><a href="<?php echo e(route('site.match.index')); ?>">События</a></object> / <object><a href="<?php echo e(route('site.match.index', ['sport' => $match->stage->season->tournament->sport->slug])); ?>"><?php echo e($match->stage->season->tournament->sport->name); ?></a></object></span>
		
	</div>
	<div class="card-body">
		<div class="card-subtitle">
			<span><?php echo e($match->stage->season->tournament->name); ?></span>
			&ndash;
			<span><?php echo e($match->stage->season->name); ?></span>,
			<?php if(false === mb_strpos(mb_strtolower($match->stage->season->tournament->name), mb_strtolower($match->stage->name))): ?>
				&ndash;
				<span><?php echo e($match->stage->name); ?></span>
			<?php endif; ?>
		</div>
		<div class="event-card__participants">
			<div class="event-card__participant">
				<h4><?php echo e($match->participants[0]->team->name); ?></h4>
				<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $match->participants[0]->team->logo)); ?>" alt="<?php echo e($match->participants[0]->team->name); ?>">
			</div>
			<div class="event-card__score">
				<?php if(in_array($match->matchstatus->slug, ['finished', 'inprogress'])): ?>
					<span class="event-card__score-1"><?php echo e($match->participants[0]->score); ?></span> 
					&ndash;
					<span class="event-card__score-2"><?php echo e($match->participants[1]->score); ?></span>
				<?php else: ?>
    				<span class="event-card__score-1">?</span> &ndash; <span class="event-card__score-2">?</span>
				<?php endif; ?>
			</div>
			<div class="event-card__participant">
				<img src="<?php echo e(asset('preview/100/100/storage/teams/' . $match->participants[1]->team->logo)); ?>" alt="<?php echo e($match->participants[1]->team->name); ?>">
				<h4><?php echo e($match->participants[1]->team->name); ?></h4>
			</div>
		</div>
		<div class="event-card__rates rates_list">
			<div class="rate">
				<?php echo e(is_null($match->odds1_current) ? '0.00' : sprintf("%0.02f", $match->odds1_current)); ?><br>
				<?php if(null !== $match->bookmaker1): ?>
					<object><a href="<?php echo e($match->bookmaker1->site); ?>" target="_blank" rel="nofollow">
						<?php if(null !== $match->bookmaker1->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmaker1->logo)); ?>" alt="<?php echo e($match->bookmaker1->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmaker1->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
			<div class="rate">
				<?php echo e(is_null($match->oddsx_current) ? '0.00' : sprintf("%0.02f", $match->oddsx_current)); ?><br>
				<?php if(null !== $match->bookmakerx): ?>
					<object><a href="<?php echo e($match->bookmakerx->site); ?>" target="_blank" rel="nofollow">
						<?php if(null !== $match->bookmakerx->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmakerx->logo)); ?>" alt="<?php echo e($match->bookmakerx->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmakerx->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
			<div class="rate">
				<?php echo e(is_null($match->odds2_current) ? '0.00' : sprintf("%0.02f", $match->odds2_current)); ?><br>
				<?php if(null !== $match->bookmaker2): ?>
					<object><a href="<?php echo e($match->bookmaker2->site); ?>" target="_blank" rel="nofollow">
						<?php if(null !== $match->bookmaker2->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmaker2->logo)); ?>" alt="<?php echo e($match->bookmaker2->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmaker2->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
		</div>
		<div class="event-card__rates rates_tile">
			<div class="rate">
				<div class="rate-val">1<br><?php echo e(is_null($match->odds1_current) ? '0.00' : sprintf("%0.02f", $match->odds1_current)); ?></div>
				<?php if(null !== $match->bookmaker1): ?>
					<object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug])); ?>">
						<?php if(null !== $match->bookmaker1->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmaker1->logo)); ?>" alt="<?php echo e($match->bookmaker1->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmaker1->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
			<div class="rate">
				<div class="rate-val">x<br><?php echo e(is_null($match->oddsx_current) ? '0.00' : sprintf("%0.02f", $match->oddsx_current)); ?></div>
				<?php if(null !== $match->bookmakerx): ?>
					<object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug])); ?>">
						<?php if(null !== $match->bookmakerx->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmakerx->logo)); ?>" alt="<?php echo e($match->bookmakerx->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmakerx->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
			<div class="rate">
				<div class="rate-val">2<br><?php echo e(is_null($match->odds2_current) ? '0.00' : sprintf("%0.02f", $match->odds2_current)); ?></div>
				<?php if(null !== $match->bookmaker2): ?>
					<object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug])); ?>">
						<?php if(null !== $match->bookmaker2->logo): ?>
							<img src="<?php echo e(asset('preview/87/26/storage/bookmakers/' . $match->bookmaker2->logo)); ?>" alt="<?php echo e($match->bookmaker2->name); ?>">
						<?php else: ?>
							<?php echo e($match->bookmaker2->name); ?>

						<?php endif; ?>
					</a></object>
				<?php endif; ?>
			</div>
		</div>
		<div class="event-btn">
			<object><a class="btn btn-light" href="<?php echo e(route('site.match.show', ['match' => $match->id])); ?>">Подробнее</a></object>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<object><a class="btn btn-light" href="<?php echo e(route('site.match.show', ['match' => $match->id])); ?>">Подробнее</a></object>
			
		</div>
		<div class="event-date">
			<div class="text-uppercase"><?php echo e($match->matchstatus->name); ?></div>
			<div class="date"><?php echo e($match->started_at->format('d.m.Y H:i')); ?></div>
		</div>
	</div>
</a><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/match/home.blade.php ENDPATH**/ ?>