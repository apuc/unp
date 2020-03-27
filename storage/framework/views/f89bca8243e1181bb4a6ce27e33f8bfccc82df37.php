<?php $__env->startSection('content'); ?>
	<div class="card-wrap account-forecasts-detail">
		<h2 class="title">Прогноз</h2>
		<form data-ss-forecasts-form id="forecast-form" action="<?php echo e(route('account.forecast.store')); ?>" method="post" enctype="multipart/form-data" onsubmit="return false;">
			<input type="hidden" name="forecaststatus_id" value="">
			<?php echo e(csrf_field()); ?>


			<div data-ss-forecasts-sports></div>
			<div data-ss-forecasts-tournaments></div>
			<div data-ss-forecasts-matches></div>
			<div data-ss-forecasts-offers></div>

			<div data-ss-forecasts-rate hidden class="form-group row">
				<label class="col-md-3 col-form-label">Сумма ставки <span class="red">*</span></label>
				<div class="col-md-9">
					<div class="form-row">
						
						<div class="col-6 col-md-4">
							<select name="bet" class="form-control">
								<option value="">-- Выберите сумму ставки</option>
								<option value="50">50 Баллов</option>
								<option value="100">100 Баллов</option>
								<option value="250">250 Баллов</option>
								<option value="500">500 Баллов</option>
								<option value="1000">1000 Баллов</option>
							</select>
						</div>
					</div>
				</div>
			</div>

			<div data-ss-forecasts-description hidden class="form-group">
				<label for="description">Описание</label>
				<div>
					
					<textarea name="description" class="form-control" id="description" rows="10"></textarea>
				</div>
			</div>

			<div data-ss-forecasts-btn hidden class="mt-3 ml-4">
				<button type="submit" class="btn btn-primary btn-lg">Отправить</button>
			</div>
		</form>

		
	</div>

	<script>
		$(document).ready(function () {
			var dataset = {};

			<?php if(null !== request()->sport_id): ?>
				dataset['sport_id'] = '<?php echo e(request()->sport_id); ?>';
			<?php endif; ?>

			<?php if(null !== request()->tournament_id): ?>
				dataset['tournament_id'] = '<?php echo e(request()->tournament_id); ?>';
			<?php endif; ?>

			<?php if(null !== request()->match_id): ?>
				dataset['match_id'] = '<?php echo e(request()->match_id); ?>';
			<?php endif; ?>

			<?php if(null !== request()->type): ?>
				dataset['type'] = '<?php echo e(request()->type); ?>';
			<?php endif; ?>

			<?php if(null !== request()->scope): ?>
				dataset['scope'] = '<?php echo e(request()->scope); ?>';
			<?php endif; ?>

			ssForecasts('<?php echo e(route('account.forecast.sports')); ?>', dataset).load();

			$('#forecast-form').find("*[name='bet']").bind('change', function () {
				if ($(this).val() == '') {
					$("*[data-ss-forecasts-description]").attr('hidden', true);
					$("*[data-ss-forecasts-btn]").attr('hidden', true);
				}

				else {
					$("*[data-ss-forecasts-description]").removeAttr('hidden');
					$("*[data-ss-forecasts-btn]").removeAttr('hidden');
				}
			});

			$('#forecast-form').find('button').bind('click', function () {
				ssForecasts('<?php echo e(route('account.forecast.store')); ?>').save();
			});
		});
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/forecast/create.blade.php ENDPATH**/ ?>