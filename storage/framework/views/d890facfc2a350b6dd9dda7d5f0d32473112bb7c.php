<div data-ss-forecasts-matches class="form-group row">
	<label for="match" class="col-md-3 col-form-label">Матч <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'<?php echo e(route('account.forecast.offers')); ?>',
				{
					'match_id': $('#match').val()
				}
			).load();
		" name="match_id" class="form-control" id="match">
			<option value="">-- Выберите матч</option>
			<?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option <?php echo $match_id == $match['id'] ? 'selected="selected"' : ''; ?> value="<?php echo e($match['id']); ?>"><?php echo e($match['team1_name']); ?> &ndash; <?php echo e($match['team2_name']); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/matches.blade.php ENDPATH**/ ?>