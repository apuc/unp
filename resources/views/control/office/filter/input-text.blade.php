@php
	$mask = $mask ?? null;
@endphp

<div class="form-group row">
	<label for="f_{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<input {!! filled($mask) ? 'data-mask="' . $mask . '"' : '' !!} {!! filled($readonly) ? 'readonly="readonly"' : '' !!} class="form-control" type="text" id="f_{{ $field }}" name="f_{{ $field }}" value="{{ $value }}">
	</div>
</div>
