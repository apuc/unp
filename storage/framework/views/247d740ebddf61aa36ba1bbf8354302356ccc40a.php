<div data-ss-filter-url="<?php echo e(route('site.deal.filter')); ?>" class="filter-box accordion" id="filter-box">
	<div class="hd collapsed"
	  role="button"
	  data-toggle="collapse"
	  data-target="#filter"
	  aria-expanded="false"
	  aria-controls="filter"><i class="fa fa-sliders" aria-hidden="true"></i> Фильтр</div>
	<div class="collapse" id="filter" data-parent="#filter-box">
		<?php if(!is_null(Bookmakerparameter::topical('type'))): ?>
			<div class="filter-options">
				<h5 role="button" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type"><span class="dashed">Предлагаемый бонус</span></h5>
				<div class="collapse show" id="type" data-parent="#filter">
					<div id="param-type">
						<?php $__currentLoopData = Bookmakerparameter::topical('type')->getParameters()['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

						<?php if(Bookmakerparameter::get('type', false)): ?>
							<input type="hidden" data-ss-pn-parameter="type" value="<?php echo e(Bookmakerparameter::get('type')); ?>">
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/sidebar/bookmakers.blade.php ENDPATH**/ ?>