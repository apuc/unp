<div class="sorting d-flex justify-content-end mt-3">
	<div class="sort-box mr-auto">
		<span class="sort-box__title">Сортировка</span>
		<div class="sort-box__select">
			<select data-ss-pn-parameter="s" data-ss-pn-submit="change" class="form-control form-control-sm">
				<option <?php echo 'users.stat_profit' 	=== $users['sort']	? 'selected="selected"' : ''; ?> value="0">По прибыли</option>
				<option <?php echo 'users.stat_roi' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="1">По ROI</option>
				<option <?php echo 'users.stat_forecasts' 	=== $users['sort']	? 'selected="selected"' : ''; ?> value="2">По количеству прогнозов</option>
				<option <?php echo 'users.stat_wins' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="3">По выигрышам</option>
				<option <?php echo 'users.stat_losses' 	=== $users['sort']	? 'selected="selected"' : ''; ?> value="4">По проигрышам</option>
				<option <?php echo 'users.stat_draws' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="5">По отменам</option>
				<option <?php echo 'users.stat_offer' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="6">По среднему коэффициенту</option>
				
				<option <?php echo 'users.stat_luck' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="8">По проценту выигрышных прогнозов</option>
				<option <?php echo 'users.balance' 		=== $users['sort']	? 'selected="selected"' : ''; ?> value="9">По банку</option>
			</select>
		</div>
	</div>

	<div class="product-view">
		<input data-ss-pn-parameter="v" type="hidden" value="<?php echo e($users['view']); ?>">
		<span class="product-view__title">Вид</span>
		<span
			class="product-view__item view-as-grid <?php echo e('0' == $users['view'] ? 'selected' : ''); ?>"
			title="Плитка"
			data-ss-pn-submit="click"
			data-ss-pn-v-value="0"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="0"></i>
		</span>
		<span
			class="product-view__item view-as-list <?php echo e('1' == $users['view'] ? 'selected' : ''); ?>"
			title="Список"
			data-ss-pn-submit="click"
			data-ss-pn-v-value="1"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="1"></i>
		</span>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/panel/user/sort.blade.php ENDPATH**/ ?>