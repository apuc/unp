<div class="sorting d-flex justify-content-end">
	<div class="sort-box mr-auto">
		<span class="sort-box__title">Сортировка</span>
		<div class="sort-box__select">
			<select data-ss-pn-parameter="s" data-ss-pn-submit="change" class="form-control form-control-sm">
				<option <?php echo 'name' === $bookmakers['sort']	? 'selected="selected"' : ''; ?> value="0">По алфавиту</option>
				<option <?php echo 'bonus' === $bookmakers['sort']	? 'selected="selected"' : ''; ?> value="1">По бонусу</option>
			</select>
		</div>
	</div>

	<div class="product-view">
		<input data-ss-pn-parameter="v" type="hidden" value="<?php echo e($bookmakers['view']); ?>">
		<span class="product-view__title">Вид</span>
		<span
			class="product-view__item view-as-grid <?php echo e('0' == $bookmakers['view'] ? 'selected' : ''); ?>"
			title="Плитка"
			data-ss-pn-submit="click" data-ss-pn-v-value="0"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="0"></i>
		</span>
		<span
			class="product-view__item view-as-list <?php echo e('1' == $bookmakers['view'] ? 'selected' : ''); ?>"
			title="Список"
			data-ss-pn-submit="click" data-ss-pn-v-value="1"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="1"></i>
		</span>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/panel/bookmaker/sort.blade.php ENDPATH**/ ?>