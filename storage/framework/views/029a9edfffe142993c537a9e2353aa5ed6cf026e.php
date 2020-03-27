<div class="card tournament-card">
	<div class="card-body">
		<?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<h5>
				<a href="<?php echo e(route('site.match.index', ['sport' => $sport->slug])); ?>">
					<span class="sport-icon"><img src="<?php echo e(asset('preview/24/24/storage/sports/' . $sport->icon)); ?>" alt="<?php echo e($sport->name); ?>"></span><?php echo e($sport->name); ?></a>
			</h5>
			<ul>
				<?php $__currentLoopData = $sport->tournaments->filter(function ($record) {
						return $record->o == 0;
					}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<a href="<?php echo e(route('site.match.index', ['tournament' => $tournament->id])); ?>">
							<span class="b-matches__tournament-flag"><img src="<?php echo e(asset('preview/40/40/storage/tournaments/' . $tournament->logo)); ?>" alt="<?php echo e($tournament->name); ?>"></span>
							<?php echo e($tournament->name); ?>

						</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php $__currentLoopData = $sport->tournaments->filter(function ($record) {
						return $record->o == 1;
					})->slice(0, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<a href="<?php echo e(route('site.match.index', ['tournament' => $tournament->id])); ?>">
							<span class="b-matches__tournament-flag"><img src="<?php echo e(asset('preview/40/40/storage/tournaments/' . $tournament->logo)); ?>" alt="<?php echo e($tournament->name); ?>"></span>
							<?php echo e($tournament->name); ?>

						</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/tournament/home.blade.php ENDPATH**/ ?>