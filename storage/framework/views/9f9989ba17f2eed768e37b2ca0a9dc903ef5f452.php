<div data-ss-forecasts-sports class="form-group row">
	<label for="sport" class="col-md-3 col-form-label">Спорт <span class="red">*</span></label>
	<div class="col-md-9">
		<select onchange="
			ssForecasts(
				'<?php echo e(route('account.forecast.tournaments')); ?>',
				{
					'sport_id': $('#sport').val()
				}
			).load();
		" name="sport_id" class="form-control" id="sport">
			<option value="">-- Выберите спорт</option>
			<?php $__currentLoopData = $sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option <?php echo $sport_id == $sport['id'] ? 'selected="selected"' : ''; ?> value="<?php echo e($sport['id']); ?>"><?php echo e($sport['name']); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/sports.blade.php ENDPATH**/ ?>