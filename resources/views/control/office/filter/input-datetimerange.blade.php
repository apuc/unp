@php
	$value = $value ?? [null, null];
@endphp
<div class="form-group row">
	<label for="f_{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<div id="f_{{ $field }}" class="input-group">
			<input class="form-control input-range" type="text" id="f_{{ $field }}0" name="f_{{ $field }}[0]" value="{{ filled($value[0]) ? $value[0]->format('d.m.Y H:i:s') : null }}">
			&nbsp;&ndash;&nbsp;
			<input class="form-control input-range" type="text" id="f_{{ $field }}1" name="f_{{ $field }}[1]" value="{{ filled($value[1]) ? $value[1]->format('d.m.Y H:i:s') : null }}">
		</div>

		<script>
			jQuery.datetimepicker.setLocale('{{ config('app.locale') }}');
			$('#f_{{ $field }}0').datetimepicker({
				format: 'd.m.Y H:i:s'
			});
			$('#f_{{ $field }}1').datetimepicker({
				format: 'd.m.Y H:i:s'
			});
		</script>
	</div>
</div>
