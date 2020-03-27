<div class="b-filter-top">
	<div class="b-filter-top__sport-nav">
		<ul class="b-filter-top__sport-main-list">
			<li class="b-filter-top__sport-main-item">
				<a
					href="javascript: void(0);"
					data-ss-pn-submit="click"
					data-ss-pn-sport-value=""
					class="nav-link <?php echo false === Briefparameter::get('sport', false) ? 'active' : ''; ?>"
				>Все</a>
			</li>
			<?php if(!is_null(Briefparameter::topical('sport'))): ?>
				<?php if(Briefparameter::get('sport', false)): ?>
					<input
						data-ss-pn-parameter="sport"
						type="hidden"
						value="<?php echo e(Briefparameter::get('sport')); ?>"
					>
				<?php endif; ?>

				<?php $__currentLoopData = Briefparameter::topical('sport')->getParameters()['values']->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li class="b-filter-top__sport-main-item">
						<a
							href="javascript: void(0);"
							data-ss-pn-submit="click"
							data-ss-pn-sport-value="<?php echo e($value['value']); ?>"
							class="nav-link <?php echo $value['current'] ? 'active' : ''; ?>"
						><?php echo e($value['name']); ?></a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				<?php if(Briefparameter::topical('sport')->getParameters()['values']->count() > 3): ?>
					<li class="b-filter-top__sport-main-item b-filter-top__sport-other-button">
						<a class="
							nav-link
							dropdown-toggle

							<?php if(Briefparameter::topical('sport')->getParameters()['values']->slice(3)->filter(function ($value) {
								return $value['current'];
							})->count()): ?>
								active
							<?php endif; ?>
						" href="#">Прочие</a>

						<div class="win-nav b-filter-top__sport-other-pulldown">
							<div class="win-cont">
								<ul>
									<?php $__currentLoopData = Briefparameter::topical('sport')->getParameters()['values']->slice(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li class="nav-item">
											<a
												href="javascript: void(0);"
												data-ss-pn-submit="click"
												data-ss-pn-sport-value="<?php echo e($value['value']); ?>"
												class="<?php echo $value['current'] ? 'active' : ''; ?>"
											><?php echo e($value['name']); ?></a>
										</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>
						</div>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>

		<?php if(!is_null(Briefparameter::topical('day'))): ?>
			<?php if(Briefparameter::get('day', false)): ?>
				<input
					data-ss-pn-parameter="day"
					data-ss-filter-input="day"
					type="hidden"
					value="<?php echo e(Briefparameter::get('day')); ?>"
				>
			<?php endif; ?>

			<div class="b-filter-top__calendar b-calendar">
				<div class="b-calendar__nav">
					<div class="b-calendar__nav-prev" title="Предыдущий день"></div>
				</div>
				<div class="b-calendar__date-picker">
					<div class="b-calendar__button" id="calendar-dates" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="b-calendar__icon"></span> <span><?php echo e(call_user_func(function () {
								$day = Briefparameter::get('day', now()->format('Y-m-d'));
								return ''
									. now()->parse($day)->format('d/m ')
									. trans('days.abb.' . now()->parse($day)->format('w'))
								;
							})); ?></span>
					</div>
					<div class="b-calendar-dates dropdown-menu" aria-labelledby="calendar-dates">
						<?php $__currentLoopData = Briefparameter::topical('day')->getParameters()['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div
								data-ss-pn-submit="click"
								data-ss-pn-day-value="<?php echo e($value['value']); ?>"
								class="day <?php echo $value['current'] ? 'active' : ''; ?>"
							><?php echo e($value['name_format']); ?><span hidden><?php echo e($value['name']); ?></span></div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
				<div class="b-calendar__nav">
					<div class="b-calendar__nav-next" title="Следующий день"></div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/panel/brief/filter.blade.php ENDPATH**/ ?>