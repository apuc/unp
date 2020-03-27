<div data-ss-forecasts-tournaments class="form-group row">
	<label for="tournament" class="col-md-3 col-form-label">Чемпионат <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'<?php echo e(route('account.forecast.matches')); ?>',
				{
					'tournament_id': $('#tournament').val(),
					'bookmaker_id': $('#bookmaker').val()
				}
			).load();
		" name="tournament_id" class="form-control" id="tournament">
			<option value="">-- Выберите турнир</option>
			<?php $__currentLoopData = $tournaments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tournament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option <?php echo $tournament_id == $tournament['id'] ? 'selected="selected"' : ''; ?> value="<?php echo e($tournament['id']); ?>"><?php echo e($tournament['name']); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/tournaments.blade.php ENDPATH**/ ?>