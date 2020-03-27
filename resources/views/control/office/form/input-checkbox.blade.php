<div class="form-group row">
	<div class="col-sm-{{ $colinput }} ml-sm-auto">
		<div class="custom-control custom-checkbox">
			<div id="{{ $field }}-check-hidden" class="hidden">
				<input type="text" name="{{ $field }}" value="{{ $value ?? 0 }}">
			</div>

			<input
				class="custom-control-input"

				id="{{ $field }}-check-control"

				@if ($value)
					checked="checked"
				@endif

				onchange="
					if ($(this).prop('checked') == true)
						$('#{{ $field }}-check-hidden').find('input').val(1);
					else
						$('#{{ $field }}-check-hidden').find('input').val(0);
				"

				type="checkbox"
			>

			<label for="{{ $field }}-check-control" class="custom-control-label">
				@lang('field.office.' . $field)
			</label>
		</div>
	</div>
</div>