<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<textarea {!! filled($readonly) ? 'readonly="readonly"' : '' !!} rows="8" class="form-control" id="{{ $field }}" name="{{ $field }}">{{ $value }}</textarea>
	</div>
</div>
