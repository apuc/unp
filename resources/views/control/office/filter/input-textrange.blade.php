@php
	$value	= $value ?? [null, null];
	$mask	= $mask ?? null;
@endphp
<div class="form-group row">
	<label for="f_{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<div id="f_{{ $field }}" class="input-group">
			<input {!! filled($mask) ? 'data-mask="' . $mask . '"' : '' !!} class="form-control input-range" type="text" id="f_{{ $field }}0" name="f_{{ $field }}[0]" value="{{ $value[0] }}">
			&nbsp;&ndash;&nbsp;
			<input {!! filled($mask) ? 'data-mask="' . $mask . '"' : '' !!} class="form-control input-range" type="text" id="f_{{ $field }}1" name="f_{{ $field }}[1]" value="{{ $value[1] }}">
		</div>
	</div>
</div>
