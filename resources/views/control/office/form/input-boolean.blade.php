@php
	$value = $value ?? null;
@endphp
<div class="form-group row">
	<label class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<div class="custom-control custom-radio custom-control-inline">
			<input
				value=""
				name="{{ $field }}"
				{!! empty($value) ? 'checked="checked"' : '' !!}
				type="radio"
				class="custom-control-input"
				id="{{ $field }}_all"
			>
			<label class="custom-control-label" for="{{ $field }}_all">@lang('field.office.all')</label>
		</div>

		<div class="custom-control custom-radio custom-control-inline">
			<input
				value="1"
				name="{{ $field }}"
				{!! 1 == $value ? 'checked="checked"' : '' !!}
				type="radio"
				class="custom-control-input"
				id="{{ $field }}_true"
			>
			<label class="custom-control-label" for="{{ $field }}_true">@lang('field.office.yes')</label>
		</div>

		<div class="custom-control custom-radio custom-control-inline">
			<input
				value="0"
				name="{{ $field }}"
				{!! filled($value) && 0 === (int)$value ? 'checked="checked"' : '' !!}
				type="radio"
				class="custom-control-input"
				id="{{ $field }}_false"
			>
			<label class="custom-control-label" for="{{ $field }}_false">@lang('field.office.no')</label>
		</div>
	</div>
</div>