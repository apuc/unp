<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<input class="form-control" type="text" id="{{ $field }}" name="{{ $field }}" value="{{ filled($value) ? $value->format('d.m.Y H:i') : null }}">
		<script>
			jQuery.datetimepicker.setLocale('{{ config('app.locale') }}');
			$('#{{ $field }}').datetimepicker({
				format: 'd.m.Y H:i'
			});
		</script>
	</div>
</div>
