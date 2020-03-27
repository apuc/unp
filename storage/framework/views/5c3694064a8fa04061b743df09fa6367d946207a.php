<?php $__env->startSection('columns'); ?>
	<div id="nav">
		<?php if(!empty($bookmakers)): ?>
			<table class="table table-sm bets-table">
				<thead>
					<tr>
						<th class="bookmaker">Букмекер</th>
						<th class="outcomesubtype">Да <span class="active-down"></span></th>
						<th class="outcomesubtype">Нет <span class="active-down"></span></th>
					</tr>
					<?php $__currentLoopData = $bookmakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker_id => $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

							<?php
								$offer = collect($bookmaker['offers'])->filter(function ($offer) {
									return $offer['outcomesubtype_slug'] == 'yes';
								})->first();
							?>
							<td
								data-ss-forecasts-offer-bookmaker-id="<?php echo e($bookmaker_id); ?>"
								data-ss-forecasts-offer-bookmaker-picture="<?php echo e(asset('preview/64/26' . $bookmaker['logo'])); ?>"
								data-ss-forecasts-offer-bookmaker-name="<?php echo e($bookmaker['name']); ?>"
								data-ss-forecasts-offer-outcome-id="<?php echo e($offer['outcome_id']); ?>"
								data-ss-forecasts-offer-rate="<?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf('%0.02f', $offer['odds_current'])); ?>"
								data-ss-forecasts-offer-description="Да, <?php echo e($offer['outcometype_name']); ?>, <?php echo e($offer['outcomescope_name']); ?>"
								class="odds"
							>
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
							</td>

							<?php
								$offer = collect($bookmaker['offers'])->filter(function ($offer) {
									return $offer['outcomesubtype_slug'] == 'no';
								})->first();
							?>
							<td
								data-ss-forecasts-offer-bookmaker-id="<?php echo e($bookmaker_id); ?>"
								data-ss-forecasts-offer-bookmaker-picture="<?php echo e(asset('preview/64/26' . $bookmaker['logo'])); ?>"
								data-ss-forecasts-offer-bookmaker-name="<?php echo e($bookmaker['name']); ?>"
								data-ss-forecasts-offer-outcome-id="<?php echo e($offer['outcome_id']); ?>"
								data-ss-forecasts-offer-rate="<?php echo e(is_null($offer['odds_current']) ? '0.00' : sprintf('%0.02f', $offer['odds_current'])); ?>"
								data-ss-forecasts-offer-description="Нет, <?php echo e($offer['outcometype_name']); ?>, <?php echo e($offer['outcomescope_name']); ?>"
								class="odds"
							>
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
							</td>
						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</thead>
			</table>
		<?php else: ?>
			<p class="text-center pb-3 pt-3">Данных нет</p>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/bts.blade.php ENDPATH**/ ?>