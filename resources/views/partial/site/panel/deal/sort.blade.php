<div class="sorting d-flex justify-content-end">
	<div class="sort-box mr-auto">
		<span class="sort-box__title">Сортировка</span>
		<div class="sort-box__select">
			<select data-ss-pn-parameter="s" data-ss-pn-submit="change" class="form-control form-control-sm">
				<option {!! 'name' === $deals['sort']			? 'selected="selected"' : '' !!} value="0">По алфавиту</option>
				<option {!! 'started_at' === $deals['sort']		? 'selected="selected"' : '' !!} value="1">По дате</option>
			</select>
		</div>
	</div>

	<div class="product-view">
		<input data-ss-pn-parameter="v" type="hidden" value="{{ $deals['view'] }}">
		<span class="product-view__title">Вид</span>
		<span
			class="product-view__item view-as-grid {{ '0' == $deals['view'] ? 'selected' : '' }}"
			title="Плитка"
			data-ss-pn-submit="click" data-ss-pn-v-value="0"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="0"></i>
		</span>
		<span
			class="product-view__item view-as-list {{ '1' == $deals['view'] ? 'selected' : '' }}"
			title="Список"
			data-ss-pn-submit="click" data-ss-pn-v-value="1"
		>
			<i data-ss-pn-submit="click" data-ss-pn-v-value="1"></i>
		</span>
	</div>
</div>