<div class="form-group row">
	<label for="f_{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<input class="form-control" type="text" id="f_{{ $field }}" name="f_{{ $field }}" value="{{ filled($value) ? $value->format('d.m.Y') : null }}">
		<script>
			jQuery.datetimepicker.setLocale('{{ config('app.locale') }}');
			$('#f_{{ $field }}').datetimepicker({
				timepicker:	false,
				format:		'd.m.Y'
			});
		</script>
	</div>
</div>
