<div class="form-group row">
	<label for="{{ $field . '_id' }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<select class="custom-select" id="{{ $field . '_id' }}" name="{{ $field . '_id' }}">
			<option value="">-- @lang('field.office.select')</option>
			@foreach($options as $option)
				<option value="{{ $option->id }}"{{ $id == $option->id ? ' selected' : '' }}>{{ (gettype($lookup) == 'string') ? $option->$lookup : call_user_func($lookup, $option) }}</option>
			@endforeach
		</select>
	</div>
</div>
