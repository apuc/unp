<div data-ss-filter-url="<?php echo e(route('account.forecast.filter')); ?>" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
		role="button"
		data-toggle="collapse"
		data-target="#filter"
		aria-expanded="false"
		aria-controls="filter"
	>
		<i class="fa fa-sliders" aria-hidden="true"></i> МОИ ЛИГИ
	</div>

	<div class="collapse" id="filter" data-parent="#filter-box">

		<?php if(!is_null(Forecastparameter::topical('tournament'))): ?>
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#tournament" aria-expanded="true" aria-controls="tournament"><span class="dashed">Турниры</span></h5>
				<div class="collapse show" id="tournament" data-parent="#filter">
					<div id="param-tournament">
						<?php $__currentLoopData = Forecastparameter::topical('tournament')->getParameters()['values']->filter(function ($param) {
								return !is_null($param['position']);
							})->sortBy(function ($param, $key) {
								return $param['position'];
							}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="tournament"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									<?php echo $value['current'] ? 'checked="checked"' : ''; ?>

									id="tournament<?php echo e($key); ?>"
									value="<?php echo e($value['value']); ?>"
								>
								<label class="custom-control-label" for="tournament<?php echo e($key); ?>">
									<div><span class="dashed"><?php echo e($value['name']); ?></span></div>
								</label>
							</a>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php $__currentLoopData = Forecastparameter::topical('tournament')->getParameters()['values']->filter(function ($param) {
								return is_null($param['position']);
							}); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="tournament"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									<?php echo $value['current'] ? 'checked="checked"' : ''; ?>

									id="tournament<?php echo e($key); ?>"
									value="<?php echo e($value['value']); ?>"
								>
								<label class="custom-control-label" for="tournament<?php echo e($key); ?>">
									<div><span class="dashed"><?php echo e($value['name']); ?></span></div>
								</label>
							</a>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php if(Forecastparameter::get('tournament', false)): ?>
							<input type="hidden" data-ss-pn-parameter="tournament" value="<?php echo e(Forecastparameter::get('tournament')); ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!is_null(Forecastparameter::topical('status'))): ?>
			<div id="filter-options-status" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#status" aria-expanded="true" aria-controls="status"><span class="dashed">Статус</span></h5>
				<div class="collapse show" id="status" data-parent="#filter-options-status">
					<div id="param-status" class="filter-options-body">
						<select
							data-ss-filter-select="status"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Статус</option>
							<?php $__currentLoopData = Forecastparameter::topical('status')->getParameters()['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option
									<?php echo $value['current'] ? 'selected="selected"' : ''; ?>

									value="<?php echo e($value['value']); ?>"
								>
									<?php echo e($value['name']); ?>

								</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						</select>

						<?php if(Forecastparameter::get('status', false)): ?>
							<input type="hidden" data-ss-pn-parameter="status" value="<?php echo e(Forecastparameter::get('status')); ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="filter-btns">
			
			<a href="<?php echo e(route('account.forecast.index')); ?>" class="btn btn-light">Сбросить фильтр</a>
		</div>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/account/sidebar/forecasts.blade.php ENDPATH**/ ?>