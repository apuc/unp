<div class="card event-card">
	<div class="card-header">
		<span class="name"><a href="<?php echo e(route('site.match.index')); ?>">События</a> / <a href="<?php echo e(route('site.match.index', ['sport' => $match->tournament->sport->slug])); ?>"><?php echo e($match->tournament->sport->name); ?></a></span>
		
	</div>
	<div class="card-body">
		<div class="card-subtitle"><a href="#"><?php echo e($match->tournament->name); ?></a>, <a href="#"><?php echo e($match->season->name); ?></a>, <a href="#"><?php echo e($match->stage->name); ?></a></div>
		<div class="event-card__teams">
			<div class="team"><?php echo e($match->participants[0]->team->name); ?></div>
			<div class="team-result">
				<img src="/temp/logo/patriotas-fs.gif" alt="">
				<div class="result">
					<?php echo e(($match->participants[0]->score ?? '?')); ?>

					-
					<?php echo e(($match->participants[1]->score ?? '?')); ?>

				</div>
				<img src="/temp/logo/onse-kaldas.png" alt="">
			</div>
			<div class="team"><?php echo e($match->participants[1]->team->name); ?></div>
		</div>
		<div class="event-card__rates rates_list">
			<div class="rate">
				<?php echo e($match->rate1); ?><br>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmaker1->logo)); ?>" alt="<?php echo e($match->bookmaker1->name); ?>"></a>
			</div>
			<div class="rate">
				<?php echo e($match->ratex); ?><br>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmakerx->logo)); ?>" alt="<?php echo e($match->bookmakerx->name); ?>"></a>
			</div>
			<div class="rate">
				<?php echo e($match->rate2); ?><br>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmaker2->logo)); ?>" alt="<?php echo e($match->bookmaker2->name); ?>"></a>
			</div>
		</div>
		<div class="event-card__rates rates_tile">
			<div class="rate">
				<div class="rate-val">1<br><?php echo e($match->rate1); ?></div>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker1->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmaker1->logo)); ?>" alt="<?php echo e($match->bookmaker1->name); ?>"></a>
			</div>
			<div class="rate">
				<div class="rate-val">x<br><?php echo e($match->ratex); ?></div>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmakerx->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmakerx->logo)); ?>" alt="<?php echo e($match->bookmakerx->name); ?>"></a>
			</div>
			<div class="rate">
				<div class="rate-val">2<br><?php echo e($match->rate2); ?></div>
				<a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $match->bookmaker2->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $match->bookmaker2->logo)); ?>" alt="<?php echo e($match->bookmaker2->name); ?>"></a>
			</div>
		</div>
		<div class="event-btn">
			<a class="btn btn-light" href="<?php echo e(route('site.match.show', ['match' => $match->id])); ?>">Подробнее</a>
		</div>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<a class="btn btn-light" href="<?php echo e(route('site.match.show', ['match' => $match->id])); ?>">Подробнее</a>
			<a href="#" class="card-icon"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> 4</a>
			
		</div>
		<div class="event-date">
			<div class="text-uppercase"><?php echo e($match->matchstatus->name); ?></div>
			<div class="date"><?php echo e($match->started_at->format('d.m.Y H:i')); ?></div>
		</div>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/match/normal.blade.php ENDPATH**/ ?>