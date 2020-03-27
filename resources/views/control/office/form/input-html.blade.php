<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<script>
			@php
				$ckeditor = 'ckeditor_' . $field . '_' . time();
			@endphp

			$(document).ready(function () {
				var {{ $ckeditor }} = CKEDITOR.replace('{{ $field }}');
				{{ $ckeditor }}.on( 'change', function (ev) {
					$('#{{ $field }}').val({{ $ckeditor }}.getData());
				});

				{{ $ckeditor }}.config.allowedContent = true;
			});
		</script>
		<textarea class="form-control" id="{{ $field }}" name="{{ $field }}">{{ $value }}</textarea>
	</div>
</div>