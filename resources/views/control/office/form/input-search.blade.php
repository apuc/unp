<div class="form-group row">
	<label for="{{ $field . '_id' }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div id="{{ $field }}" class="col-sm-{{ $colinput }}">
		<input type="hidden" name="{{ $field . '_id' }}" value="{{ $id }}">

		<div id="{{ $field . '_id' }}" class="input-group">
			<input placeholder="@lang('field.office.select')" class="form-control ss-search-select-result" type="text" value="{{ $value }}">
			<div class="input-group-append">
				<span class="input-group-text">
					<i class="ss-search-deselect fa fa-times"></i>
				</span>
			</div>
			@if(filled($create))
				<div class="input-group-append">
					<span class="input-group-text">
						<i onclick="ssCRUD().sleep().setValues().setRedirect().setAction('{{ $field }}-create').load('{{ $create }}', '{{ $field }}');" class="ss-search-create fa fa-plus"></i>
					</span>
				</div>
			@endif
		</div>

		<script>
			var search_{{ $field . '_id' }};

			$(document).ready(function () {
				// инициализируем поиск
				search_{{ $field . '_id' }} = new ssSearch({
					obj:        '#{{ $field }}',
					ajaxPath:   '{{ $search }}',
					field:      '{{ $field . '_id' }}',
					notFound:   '@lang('field.office.notfound')',
					token:      '{{ csrf_token() }}'
				});

				search_{{ $field . '_id' }}.init();
			});
		</script>

		<div style="display: none;" class="ss-search-list-box dropdown-menu">
			<input id="{{ $field . '_enter' }}" class="form-control ss-search-field" type="text" value="">

			<div class="ss-search-list">
				<ul></ul>
			</div>
		</div>
		<div class="hidden ss-search-keyboard-name"></div>
	</div>
</div>
