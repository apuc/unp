<?php $__env->startSection('columns'); ?>
	<div id="nav">
		<?php if(!empty($bookmakers)): ?>
			<table class="table table-sm bets-table">
				<thead>
					<tr>
						<th class="bookmaker">Букмекер</th>
						<th>Бонусы</th>
						<th class="outcomesubtype">Нечет <span class="active-down"></span></th>
						<th class="outcomesubtype">Чет <span class="active-down"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php $__currentLoopData = $bookmakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
					<td class="bookmaker">
								<a href="<?php echo e($bookmaker['site']); ?>" target="_blank" rel="nofollow">
									<?php if(null !== $bookmaker['logo']): ?>
										<img src="<?php echo e(asset('preview/64/26' . $bookmaker['logo'])); ?>" alt="<?php echo e($bookmaker['name']); ?>">
									<?php else: ?>
										<?php echo e($bookmaker['name']); ?>

									<?php endif; ?>
								</a>
							</td>
							<td>
								<?php if($bookmaker['bonus'] > 0): ?>
									<a href="<?php echo e($bookmaker['site']); ?>" target="_blank" rel="nofollow">
										<span class="deal"><?php echo e($bookmaker['bonus']); ?></span>
									</a>
								<?php else: ?>
									&nbsp;
								<?php endif; ?>
							</td>

							<td class="odds">
								<?php
									$offer = collect($bookmaker['offers'])->filter(function ($offer) {
										return $offer['outcomesubtype_slug'] == 'odd';
									})->first();
								?>
								<a href="<?php echo e($bookmaker['site']); ?>" target="_blank" rel="nofollow">
    								<<?php echo e(($offer['has_offers'] ? 'span' : 'strike')); ?>

    									class="
    										<?php if($offer['odds_current'] > $offer['odds_old']): ?>
    											up
    										<?php elseif($offer['odds_current'] < $offer['odds_old']): ?>
    											down
    										<?php endif; ?>
    									"
    									data-toggle="tooltip"
    									data-placement="bottom"
    									<?php if($offer['odds_current'] != $offer['odds_old']): ?>
    										title="<?php echo e(is_null($offer['odds_old']) ? '0.00' : sprintf("%0.02f", $offer['odds_old'])); ?> &raquo; <?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current'])); ?>"
    									<?php endif; ?>
    								>
    									<?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current'])); ?>

    								</<?php echo e(($offer['has_offers'] ? 'span' : 'strike')); ?>>
								</a>
							</td>

							<td class="odds">
								<?php
									$offer = collect($bookmaker['offers'])->filter(function ($offer) {
										return $offer['outcomesubtype_slug'] == 'even';
									})->first();
								?>
								<a href="<?php echo e($bookmaker['site']); ?>" target="_blank" rel="nofollow">
    								<<?php echo e(($offer['has_offers'] ? 'span' : 'strike')); ?>

    									class="
    										<?php if($offer['odds_current'] > $offer['odds_old']): ?>
    											up
    										<?php elseif($offer['odds_current'] < $offer['odds_old']): ?>
    											down
    										<?php endif; ?>
    									"
    									data-toggle="tooltip"
    									data-placement="bottom"
    									<?php if($offer['odds_current'] != $offer['odds_old']): ?>
    										title="<?php echo e(is_null($offer['odds_old']) ? '0.00' : sprintf("%0.02f", $offer['odds_old'])); ?> &raquo; <?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current'])); ?>"
    									<?php endif; ?>
    								>
    									<?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf("%0.02f", $offer['odds_current'])); ?>

    								</<?php echo e(($offer['has_offers'] ? 'span' : 'strike')); ?>>
								</a>
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>

			<?php if($match->started_at->timestamp > now()->addMinutes(config('forecast.time'))->timestamp): ?>
				<div class="text-center pb-3">
					<a href="<?php echo e(route('account.forecast.create', [
							'sport_id'		=> $match->stage->season->tournament->sport->id,
							'tournament_id'	=> $match->stage->season->tournament->id,
							'match_id'		=> $match->id,
							'type'			=> $type,
							'scope'			=> $scope,
						])); ?>" class="btn btn-primary">Сделать прогноз</a>
				</div>
			<?php endif; ?>

		<?php else: ?>
			<p class="text-center pb-3 pt-3">Данных нет</p>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/match/oe.blade.php ENDPATH**/ ?>