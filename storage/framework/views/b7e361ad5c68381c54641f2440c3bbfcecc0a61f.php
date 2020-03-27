<div data-ss-filter-url="<?php echo e(route('site.deal.filter')); ?>" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
	  role="button"
	  data-toggle="collapse"
	  data-target="#filter"
	  aria-expanded="false"
	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> Фильтр</div>
	<div class="collapse" id="filter" data-parent="#filter-box">
		<?php if(!is_null(Dealparameter::topical('type'))): ?>
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type"><span class="dashed">Тип бонуса</span></h5>
				<div class="collapse show" id="type" data-parent="#filter">
					<div id="param-type">
						<?php $__currentLoopData = Dealparameter::topical('type')->getParameters()['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<a href="#" class="custom-control custom-checkbox">
								<input
									data-ss-filter-checkbox="type"
									data-ss-pn-submit="click"
									type="checkbox"
									class="custom-control-input"
									<?php echo $value['current'] ? 'checked="checked"' : ''; ?>

									id="type<?php echo e($key); ?>"
									value="<?php echo e($value['value']); ?>"
								>
								<label class="custom-control-label" for="type<?php echo e($key); ?>">
									<div><span class="dashed"><?php echo e($value['name']); ?></span></div>
								</label>
							</a>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php if(Dealparameter::get('type', false)): ?>
							<input type="hidden" data-ss-pn-parameter="type" value="<?php echo e(Dealparameter::get('type')); ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if(!is_null(Dealparameter::topical('bookmaker'))): ?>
			<div id="filter-options-bookmaker" class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#bookmaker" aria-expanded="true" aria-controls="bookmaker"><span class="dashed">Букмекер</span></h5>
				<div class="collapse show" id="bookmaker" data-parent="#filter-options-bookmaker">
					<div id="param-bookmaker" class="filter-options-body">
						<select
							data-ss-filter-select="bookmaker"
							data-ss-pn-submit="change"
							class="form-control form-control-sm"
						>
							<option value="">-- Букмекер</option>
							<?php $__currentLoopData = Dealparameter::topical('bookmaker')->getParameters()['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option
									<?php echo $value['current'] ? 'selected="selected"' : ''; ?>

									value="<?php echo e($value['value']); ?>"
								>
									<?php echo e($value['name']); ?>

								</option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						</select>

						<?php if(Dealparameter::get('bookmaker', false)): ?>
							<input type="hidden" data-ss-pn-parameter="bookmaker" value="<?php echo e(Dealparameter::get('bookmaker')); ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/sidebar/deals.blade.php ENDPATH**/ ?>