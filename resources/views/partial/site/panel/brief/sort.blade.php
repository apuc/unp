<div class="sorting d-flex justify-content-end">
	<div class="sort-box mr-auto">
		<span class="sort-box__title">Сортировка</span>
		<div class="sort-box__select">
			<select data-ss-pn-parameter="s" data-ss-pn-submit="change" class="form-control form-control-sm">
				<option {!! 'posted_at' === $briefs['sort']			? 'selected="selected"' : '' !!} value="0">Новые</option>
				<option {!! 'briefcomments_count' === $briefs['sort']	? 'selected="selected"' : '' !!} value="1">Комментируемые</option>
			</select>
		</div>
	</div>
</div>